<?php

namespace App\Utils;

class Hashids
{
    /**
     * @param string $value
     * @return string
     */
    public function encode(string $value): string
    {
        return $this->getHashids()->encode($value);
    }

    /**
     * @param string $value
     * @return mixed
     */
    public function decode(string $value): string
    {
        return $this->getHashids()->decode($value)[0];
    }

    /**
     * @return \Hashids\Hashids
     */
    protected function getHashids(): \Hashids\Hashids
    {
        return new \Hashids\Hashids(config('app.key'), 36);
    }
}
