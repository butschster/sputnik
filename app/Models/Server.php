<?php

namespace App\Models;

use App\Contracts\Server\ServerConfiguration as ServerConfigurationContract;
use App\Events\Server\Configured;
use App\Events\Server\Configuring;
use App\Events\Server\Created;
use App\Events\Server\Deleted;
use App\Events\Server\Failed;
use App\Events\Server\StatusChanged;
use App\Models\Concerns\DeterminesAge;
use App\Models\Concerns\HasKeyPair;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Models\Server\Action;
use App\Models\Server\Event;
use App\Models\Server\Firewall\Rule as FirewallRule;
use App\Models\Server\Module;
use App\Models\Server\Site;
use App\Models\Server\Task;
use App\Models\Subscription\Plan;
use App\Models\User\Team;
use App\Server\ServerConfiguration;
use App\Utils\SSH\ValueObjects\SystemInformation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Laravel\Scout\Searchable;

class Server extends Model
{
    use UsesUuid, DeterminesAge, HasTask, HasKeyPair, Searchable;

    const STATUS_PENDING     = 'pending';
    const STATUS_CONFIGUTING = 'configuring';
    const STATUS_CONFIGURED  = 'configured';
    const STATUS_FAILED      = 'failed';

    /**
     * {@inheritdoc}
     */
    protected $table = 'servers';

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'meta' => 'array',
        'os_information' => 'array',
        'configuring_job_dispatched_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'private_key',
        'sudo_password',
        'meta',
    ];

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    protected static function boot()
    {
        static::creating(function ($server) {
            $server->status = static::STATUS_PENDING;
        });

        static::created(function ($server) {
            event(new Created($server));
        });

        static::deleted(function ($server) {
            event(new Deleted($server));
        });

        parent::boot();
    }

    /**
     * Get server owner
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get server owner team
     *
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get pings that belong to the server.
     *
     * @return HasMany
     */
    public function pings(): HasMany
    {
        return $this->hasMany(\App\Models\Server\Ping::class);
    }

    /**
     * Get alerts that belong to the server.
     *
     * @return HasMany
     */
    public function alerts(): HasMany
    {
        return $this->hasMany(\App\Models\Server\Alert::class);
    }

    /**
     * Get users that belong to the server.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(\App\Models\Server\User::class);
    }

    /**
     * Get sites that belong to the server.
     *
     * @return HasMany
     */
    public function sites(): HasMany
    {
        return $this->hasMany(Site::class)->latest();
    }

    /**
     * Get tasks that belong to the server.
     *
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->latest();
    }

    /**
     * Get events that belong to the server.
     *
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class)->latest();
    }

    /**
     * Get firewall rules that belong to the server.
     *
     * @return HasMany
     */
    public function firewallRules(): HasMany
    {
        return $this->hasMany(FirewallRule::class)->with('task');
    }

    /**
     * Get installed server modules
     *
     * @return HasMany
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class);
    }

    /**
     * Get module by name
     *
     * @param string $module
     * @return Module
     */
    public function getModule(string $module): Module
    {
        return $this
            ->modules()
            ->where('name', $module)
            ->firstOrFail();
    }

    /**
     * Get installed server modules
     *
     * @return HasMany
     */
    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }

    /**
     * Determine if the server is waiting for configuration.
     *
     * @return bool
     */
    public function isPending(): bool
    {
        return $this->status == static::STATUS_PENDING;
    }

    /**
     * Determine if the server is currently configuring.
     *
     * @return bool
     */
    public function isConfiguring(): bool
    {
        return $this->status == static::STATUS_CONFIGUTING;
    }

    /**
     * Mark the server as configuring.
     */
    public function markAsConfiguring(): void
    {
        $this->update([
            'status' => static::STATUS_CONFIGUTING,
            'configuring_job_dispatched_at' => now(),
        ]);

        event(new Configuring($this));
        event(new StatusChanged($this, static::STATUS_CONFIGUTING));
    }

    /**
     * Determine if the server is currently configured.
     * @return bool
     */
    public function isConfigured(): bool
    {
        return $this->status == static::STATUS_CONFIGURED;
    }

    /**
     * Mark the server as configured.
     */
    public function markAsConfigured(): void
    {
        $this->update(['status' => static::STATUS_CONFIGURED]);

        event(new Configured($this));
        event(new StatusChanged($this, static::STATUS_CONFIGURED));
    }

    /**
     * Determine if the server is currently failed.
     * @return bool
     */
    public function isFailed(): bool
    {
        return $this->status == static::STATUS_FAILED;
    }

    /**
     * Mark the server as configured.
     */
    public function markAsFailed(): void
    {
        $this->update(['status' => static::STATUS_FAILED]);

        event(new Failed($this));
        event(new StatusChanged($this, static::STATUS_FAILED));
    }

    /**
     * Get information about server
     *
     * @return SystemInformation|null
     */
    public function systemInformation(): ?SystemInformation
    {
        if (!$this->os_information) {
            return null;
        }

        return new SystemInformation(
            $this->os_information['os'],
            $this->os_information['version'],
            $this->os_information['architecture']
        );
    }

    /**
     * Check id server configuration is supported
     *
     * @return bool
     */
    public function isSupported(): bool
    {
        if ($os = $this->systemInformation()) {
            return $os->isSupported();
        }

        return true;
    }

    /**
     * Filter servers only by configured
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function scopeConfigured(Builder $builder)
    {
        return $builder->where('status', static::STATUS_CONFIGURED);
    }

    /**
     * Filter servers only with monitoring
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function scopeWithMonitoring(Builder $builder)
    {
        return $builder->whereHas('team', function ($q) {
            return $q->whereHas('subscriptions', function ($q) {
                return $q->whereIn('stripe_plan', Plan::onlyActive()->withMonitoring()->pluck('name'));
            });
        });
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'ip' => $this->ip,
            'user_id' => $this->user_id,
            'team_id' => $this->team_id,
        ];
    }

    /**
     * Convert model to server configuration object
     *
     * @return ServerConfigurationContract
     */
    public function toConfiguration(): ServerConfigurationContract
    {
        return new ServerConfiguration($this);
    }

    /**
     * Get available system users with root access
     *
     * @return array
     */
    public function systemUsers(): array
    {
        return $this->users()
            ->where('is_system', true)
            ->get()
            ->all();
    }

    /**
     * Get meta data by key
     *
     * @param string $key
     * @param $default
     *
     * @return mixed
     */
    public function meta(string $key, $default)
    {
        return Arr::get($this->meta, $key, $default);
    }
}
