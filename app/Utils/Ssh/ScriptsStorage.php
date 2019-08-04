<?php

namespace App\Utils\Ssh;

use Illuminate\Support\Str;

class ScriptsStorage
{
    /**
     * Write the script to storage in preparation for upload.
     *
     * @param string $script
     * @return string Script path
     */
    public function storeScript(string $script): string
    {
        $hash = md5(Str::random(20) . $script);

        $path = storage_path('app/scripts/'.$hash);

        file_put_contents($path, $script);

        return $path;
    }
}
