<?php

namespace App\Models\Server;

use App\Models\Concerns\UsesUuid;
use App\Models\Server;
use App\Utils\SSH\ValueObjects\PublicKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * Link to the server
     *
     * @return BelongsTo
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

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
