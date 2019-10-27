<?php

namespace Module\Mysql\Models;

use Domain\Record\Entities\Record\Model;

class Database extends Model
{
    /**
     * @var string
     */
    protected $module;

    /**
     * @param string $module
     * @return $this
     */
    public function setModule(string $module): self
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module key
     *
     * @return string
     */
    public function module(): string
    {
        return $this->module;
    }

    /**
     * Get model key
     *
     * @return string
     */
    public function key(): string
    {
        return 'database';
    }

    /**
     * @return string|null
     */
    public function feature(): ?string
    {
        return 'server.database.create';
    }
}