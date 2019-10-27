<?php

namespace Domain\Record\Repositories;

use App\Models\Server;
use Domain\Record\Contracts\Entities\Record\Model;
use Domain\Record\Events\Created;
use Domain\Record\Events\Deleted;
use Domain\Record\Events\Updated;

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
        $module = $server->getModule($module)->id;

        return Server\Record::forServer($server)
            ->where('module_id', $module)
            ->where('key', $key)
            ->latest()
            ->get();
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
     * @param Model $model
     * @return Server\Record
     */
    public function store(Server $server, Model $model): Server\Record
    {
        $record = new Server\Record();
        $record->meta = $model->getMetaAttributes();
        $record->feature = $model->feature();
        $record->key = $model->key();
        $record->model = get_class($model);

        $record->server()->associate($server);
        $record->module()->associate(
            $server->getModule($model->module())
        );

        $record->save();

        event(new Created($record));

        return $record;
    }

    /**
     * @param string $recordId
     * @param Model $model
     * @return Server\Record
     */
    public function update(string $recordId, Model $model)
    {
        $record = $this->find($recordId);

        $record->meta = $model->getMetaAttributes();
        $record->update();

        event(new Updated($record));

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

        event(new Deleted($record));

        return $status;
    }
}