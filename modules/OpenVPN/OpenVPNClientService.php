<?php

namespace Module\OpenVPN;

use App\Models\Server\Record;
use App\Services\Server\Runnable;
use Domain\Task\Contracts\Task;
use Module\OpenVPN\Scripts\Client\Create;
use Module\OpenVPN\Scripts\Client\Delete;
use Module\OpenVPN\Scripts\Client\GetConfig;

class OpenVPNClientService
{
    use Runnable;

    /**
     * Get client OpenVPN config
     *
     * @param Record $record
     * @return string
     */
    public function getConfig(Record $record): string
    {
        $this->setServer($record->server);

        return $this->run(new GetConfig($record))->output;
    }

    /**
     * Add a new user
     *
     * @param Record $record
     * @return Task
     */
    public function create(Record $record): Task
    {
        $this->setServer($record->server);
        $this->setOwner($record);

        return $this->runJob(
            new Create($record)
        );
    }

    /**
     * Revoke an existing user
     *
     * @param Record $record
     * @return Task
     */
    public function delete(Record $record): Task
    {
        $this->setServer($record->server);
        $this->setOwner($record);

        return $this->runJob(
            new Delete($record)
        );
    }
}