<?php

namespace App\Models\Server;

use App\Models\Concerns\UsesUuid;
use App\Utils\Ssh\ValueObjects\PublicKey;
use Illuminate\Database\Eloquent\Model;

class Key extends Model
{
    use UsesUuid;

    /**
     * @var string
     */
    protected $table = 'server_keys';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @return PublicKey
     */
    public function toPublicKey(): PublicKey
    {
        return new PublicKey($this->name, $this->content);
    }

    /**
     * Get key fingerprint
     *
     * @return string
     */
    public function fingerprint(): string
    {
        return (new PublicKey($this->name, $this->content))->getFingerprint();
    }
}
