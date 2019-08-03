<?php

namespace App\Models;

use App\Models\Concerns\UsesUuid;
use App\Models\Server\Task;
use App\Utils\Ssh\KeyPair;
use App\Utils\Ssh\KeyStorage;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    use UsesUuid;

    const STATUS_PENDING = 'pending';

    /**
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
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
    ];

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
     * Get the path to the user's worker SSH key.
     *
     * @return string
     */
    public function keyPath()
    {
        return (new KeyStorage())->storeKey($this->id, $this->private_key);
    }
}
