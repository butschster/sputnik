<?php

namespace App\Models;

use App\Events\Server\Key\AttachedToServer;
use App\Events\Server\Key\DetachedFromServer;
use App\Models\Concerns\DeterminesAge;
use App\Models\Concerns\UsesUuid;
use App\Models\Server\Key;
use App\Models\Server\Task;
use App\Utils\SSH\Contracts\KeyStorage;
use App\Utils\SSH\ValueObjects\KeyPair;
use App\Utils\SSH\ValueObjects\PrivateKey;
use App\Utils\SSH\ValueObjects\PublicKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Server extends Model
{
    use UsesUuid, DeterminesAge;

    const STATUS_PENDING = 'pending';
    const STATUS_CONFIGUTING = 'configuring';
    const STATUS_CONFIGURED = 'configured';

    /**
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
        'configuring_job_dispatched_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'private_key',
        'key_password',
        'sudo_password',
        'database_password',
    ];

    /**
     * @var array
     */
    protected $guarded = [];

    protected static function boot()
    {
        static::creating(function ($server) {
            $server->status = static::STATUS_PENDING;
        });

        parent::boot();
    }

    /**
     * Set the SSH key attributes on the model.
     *
     * @param KeyPair $keyPair
     * @return void
     */
    public function setKeypairAttribute(KeyPair $keyPair)
    {
        $this->public_key = $keyPair->getPublicKey();
        $this->private_key = $keyPair->getPublicKey();
        $this->key_password = $keyPair->getPassword();
    }

    /**
     * Check if server has key pair
     *
     * @return bool
     */
    public function hasKeyPair(): bool
    {
        return !empty($this->public_key) && !empty($this->private_key);
    }

    /**
     * Get the tasks that belong to the server.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function keys()
    {
        return $this->belongsToMany(Key::class);
    }

    /**
     * Get the path to the user's worker SSH key.
     *
     * @return string
     */
    public function keyPath(): string
    {
        $keyStorage = app(KeyStorage::class);

        $keyStorage->storeKey(
            $key = new PrivateKey($this->id, $this->private_key)
        );

        return $key->getPath();
    }

    /**
     * Determine if the server is currently provisioning.
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
    public function markAsConfiguring()
    {
        $this->update([
            'status' => static::STATUS_CONFIGUTING,
            'configuring_job_dispatched_at' => now(),
        ]);
    }

    /**
     * Determine if the server is currently configured.
     *
     * @return bool
     */
    public function isConfigured(): bool
    {
        return $this->status == static::STATUS_CONFIGURED;
    }

    /**
     * Mark the server as configured.
     *
     * @return $this
     */
    public function markAsConfigured()
    {
        $this->update(['status' => static::STATUS_CONFIGURED]);
    }

    /**
     * Add public key to server
     *
     * @param Key $key
     */
    public function addPublicKey(Key $key)
    {
        if (!$this->keys()->where('key_id', $key->id)->exists()) {
            $this->keys()->attach($key);

            event(new AttachedToServer($this, $key));
        }
    }

    /**
     * Remove public key from server
     *
     * @param Key $key
     */
    public function removePublicKey(Key $key)
    {
        $this->keys()->detach($key);

        event(new DetachedFromServer($this, $key));
    }
}
