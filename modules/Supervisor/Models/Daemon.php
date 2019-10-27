<?php

namespace Module\Supervisor\Models;

use Domain\Record\Entities\Record\Model;

class Daemon extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $fillable = ['command', 'processes', 'user', 'directory'];

    /**
     * {@inheritDoc}
     */
    protected $casts = [
        'command' => 'string',
        'processes' => 'int',
        'user' => 'string',
        'directory' => 'string',
    ];

    /**
     * {@inheritDoc}
     */
    public function module(): string
    {
        return 'supervisor';
    }

    /**
     * {@inheritDoc}
     */
    public function key(): string
    {
        return 'daemon';
    }

    /**
     * {@inheritDoc}
     */
    public function feature(): ?string
    {
        return 'server.daemon.create';
    }
}