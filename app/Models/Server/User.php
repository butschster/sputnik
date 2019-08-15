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
     * @var string
     */
    protected $table = 'server_users';

    /**
     * @var array
     */
    protected $guarded = ['public_key', 'private_key'];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'private_key',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'is_system' => 'bool',
        'sudo' => 'bool',
    ];

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
        return $this->is_system;
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
        return $this->hasMany(UserPublicKey::class)->with('task');
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
