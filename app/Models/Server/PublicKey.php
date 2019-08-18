<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Utils\SSH\ValueObjects\PublicKey as PublicKeyValueObject;
use Illuminate\Database\Eloquent\Model;

class PublicKey extends Model
{
    use UsesUuid, HasTask, HasServer;

    /**
     * {@inheritdoc}
     */
    protected $table = 'server_public_keys';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * Convert key to Public key value object
     * @return PublicKeyValueObject
     */
    public function toPublicKey(): PublicKeyValueObject
    {
        return new PublicKeyValueObject($this->name, $this->content);
    }

    /**
     * Get key fingerprint for the key
     *
     * @return string
     */
    public function fingerprint(): string
    {
        return $this->toPublicKey()->getFingerprint();
    }
}
