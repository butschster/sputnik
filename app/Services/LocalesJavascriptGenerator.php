<?php

namespace App\Services;

use App\Contracts\Modules\ManagerInterface as ModulesManagerContract;
use Illuminate\Filesystem\Filesystem;

class LocalesJavascriptGenerator
{
    /**
     * @var ModulesManagerContract
     */
    protected $manager;

    /**
     * @var Filesystem
     */
    private $file;

    /**
     * @param Filesystem $file
     * @param ModulesManagerContract $manager
     */
    public function __construct(Filesystem $file, ModulesManagerContract $manager)
    {
        $this->file = $file;
        $this->manager = $manager;
    }

    /**
     * Compile locales template and generate
     *
     * @param string $lang
     *
     * @return bool
     */
    public function make(string $lang)
    {
        $locales = $this->getLocales($lang);
        $template = json_encode($locales);

        if ($this->file->isWritable($filePath = resource_path('lang'))) {
            $filename = "{$filePath}/{$lang}.json";

            return $this->file->put($filename, $template) !== false;
        }

        return false;
    }

    /**
     * @param string $lang
     *
     * @return array
     */
    protected function getLocales(string $lang): array
    {
        $locales = [];

        foreach ($this->manager->getModules() as $module) {
            $locales = array_merge($locales, $this->getTranslations($module->getName(), $module->getPath('resources/lang/'.$lang)));
        }

        $locales = array_merge($locales, $this->getTranslations(null, resource_path('lang/' . $lang)));

        return $locales;
    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function getLocaleFiles(string $path): array
    {
        if (!$this->file->isDirectory($path)) {
            return [];
        }

        return $this->file->files($path);
    }

    /**
     * @param string $module
     * @param string $path
     *
     * @return array
     */
    private function getTranslations($module, string $path): array
    {
        $data = [];

        foreach ($this->getLocaleFiles($path) as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);

            try {
                $data[$this->getNamespace($module, $filename)] = $this->file->getRequire($file);
            } catch (\Exception $exception) {

            }
        }

        return $data;
    }

    /**
     * @param string|null, $module
     * @param string $filename
     *
     * @return string
     */
    private function getNamespace($module, string $filename): string
    {
        return $module ? $module . ':' . $filename : $filename;
    }
}