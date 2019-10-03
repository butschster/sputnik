<?php

namespace Module\Mysql\Observers\Database;

use Illuminate\Support\Str;
use Module\Mysql\Models\Database;

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
