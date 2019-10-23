<?php

namespace Module\OpenVPN\Models;

use App\Server\Record\Model;

class Client extends Model
{
    protected $fillable = ['name'];

    /**
     * Get module key
     *
     * @return string
     */
    public function module(): string
    {
        return 'supervisor';
    }

    /**
     * Get model key
     *
     * @return string
     */
    public function key(): string
    {
        return 'client';
    }

    /**
     * @return string|null
     */
    public function feature(): ?string
    {
        return 'server.openvpn.client';
    }
}