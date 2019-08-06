<?php

namespace Tests\Concerns;

use App\Models\Server;
use Illuminate\Support\Collection;

trait ServerKeyFactory
{
    /**
     * Create a new ssh key
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Key|Collection
     */
    public function createSSHKey(array $attributes = [], int $times = null)
    {
        return $this->SSHKeyFactory($times)->create($attributes);
    }

    /**
     * Create a new ssh key and attach to the server
     *
     * @param Server $server
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Key|Collection
     */
    public function createSSHKeyForServer(Server $server, array $attributes = [], int $times = null)
    {
        $key = $this->createSSHKey($attributes, $times);

        if ($key instanceof Collection) {
            foreach ($key as $item) {
                $server->addPublicKey($item);
            }
        } else {
            $server->addPublicKey($key);
        }

        return $key;
    }

    /**
     * Make a new server
     *
     * @param array $attributes
     * @param int $times
     *
     * @return Server\Key|Collection
     */
    public function makeSSHKey(array $attributes = [], int $times = null)
    {
        return $this->SSHKeyFactory($times)->make($attributes);
    }

    /**
     * @param int|null $times
     *
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    public function SSHKeyFactory(int $times = null)
    {
        return factory(Server\Key::class, $times);
    }
}
