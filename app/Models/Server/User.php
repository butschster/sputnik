<?php

namespace App\Models\Server;

use App\Models\Concerns\HasKeyPair;
use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Models\Server\User\PublicKey as UserPublicKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use UsesUuid, HasServer, HasTask, HasKeyPair;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_users';

    /**
     * {@inheritdoc}
     */
    protected $guarded = ['public_key', 'private_key'];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'private_key',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'is_system' => 'bool',
        'sudo' => 'bool',
    ];

    /**
     * {@inheritdoc}
     */
    protected $attributes = [
        'is_system' => false,
        'sudo' => false
    ];

    /**
     * @return mixed|string
     */
    public function getSudoPasswordAttribute()
    {
        return $this->isRoot() ? '' : $this->attributes['sudo_password'];
    }

    /**
     * Check if user is root
     * @return bool
     */
    public function isRoot(): bool
    {
        return $this->name === 'root';
    }

    /**
     * @return bool
     */
    public function isSystem(): bool
    {
        return (bool) $this->is_system;
    }

    /**
     * @return string
     */
    public function homeDir(): string
    {
        if (!empty($this->home_dir)) {
            return $this->home_dir;
        }

        return '/home/' . $this->name;
    }

    /**
     * Get the keys that belong to the server.
     * @return HasMany
     */
    public function keys(): HasMany
    {
        return $this->hasMany(UserPublicKey::class, 'server_user_id');
    }

    /**
     * Attach public key to server
     *
     * @param string $name
     * @param string $content
     *
     * @return UserPublicKey
     */
    public function addPublicKey(string $name, string $content): UserPublicKey
    {
        return $this->keys()->create([
            'name' => $name,
            'key' => $content,
        ]);
    }

    /**
     * Remove public key from server
     *
     * @param UserPublicKey $key
     *
     * @throws \Exception
     */
    public function removePublicKey(UserPublicKey $key): void
    {
        $key->delete();
    }
}
