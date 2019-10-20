<?php

namespace App\Observers\Server\Record;

use App\Models\Server\Record;

class ConsumeSubscriptionFeaturesObserver
{
    /**
     * @param Record $record
     */
    public function created(Record $record): void
    {
        if ($record->feature) {
            $record->server->team->useFeature($record->feature);
        }
    }

    /**
     * @param Record $record
     */
    public function deleted(Record $record): void
    {
        if ($record->feature) {
            $record->server->team->returnFeature($record->feature);
        }
    }
}