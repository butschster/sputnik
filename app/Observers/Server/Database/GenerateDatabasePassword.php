<?php

namespace App\Observers\Server\Database;

use App\Models\Server\Database;
use Illuminate\Support\Str;

class GenerateDatabasePassword
{
    /**
     * @param Database $database
     */
    public function creating(Database $database): void
    {
        if (is_null($database->password)) {
            $database->password = Str::random();
        }
    }
}
