<?php

namespace App\Models\Server;

use App\Models\Concerns\HasServer;
use App\Models\Concerns\HasTask;
use App\Models\Concerns\UsesUuid;
use App\Utils\SSH\ValueObjects\PublicKey;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use UsesUuid, HasTask, HasServer;

    /**
     * @var string
     */
    protected $table = 'server_keys';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Convert key to Public key value object
     *
     * @return PublicKey
     */
    public function toPublicKey(): PublicKey
    {
        return new PublicKey($this->name, $this->content);
    }

    /**
     * Get key fingerprint for the key
     *
     * @return string
     */
    public function fingerprint(): string
    {
        return (new PublicKey($this->name, $this->content))->getFingerprint();
    }
}
