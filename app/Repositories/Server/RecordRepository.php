<?php

namespace App\Repositories\Server;

use App\Events\Server\Record\Created;
use App\Events\Server\Record\Deleted;
use App\Models\Server;

class RecordRepository
{
    /**
     * @param Server $server
     * @param string $module
     * @param string $key
     * @return Server\Record[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list(Server $server, string $module, string $key)
    {
        $module = $server->modules()->where('name', $module)->where('key', $key)->firstOrFail()->id;

        return Server\Record::forServer($server)->where('module', $module)->latest()->get();
    }

    /**
     * @param string $recordId
     * @return Server\Record
     */
    public function find(string $recordId): Server\Record
    {
        return Server\Record::findOrFail($recordId);
    }

    /**
     * @param Server $server
     * @param string $module
     * @param string $key
     * @param array $data
     * @param string|null $feature
     * @return Server\Record
     */
    public function store(Server $server, string $module, string $key, array $data, ?string $feature = null): Server\Record
    {
        $module = $server->modules()->where('name', $module)->firstOrFail();

        $record = new Server\Record();
        $record->meta = $data;
        $record->feature = $feature;
        $record->key = $key;
        $record->server()->associate($server);
        $record->module()->associate($module);

        $record->save();

        new Created($record);

        return $record;
    }

    /**
     * @param string $recordId
     * @param array $data
     * @return Server\Record|Server\Record[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function update(string $recordId, array $data)
    {
        $record = $this->find($recordId);

        $record->meta = $data;
        $record->update();

        return $record;
    }

    /**
     * @param string $recordId
     * @return bool|null
     * @throws \Exception
     */
    public function delete(string $recordId)
    {
        $record = $this->find($recordId);

        $status = $record->delete();

        new Deleted($record);

        return $status;
    }
}