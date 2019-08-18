<?php
declare(strict_types=1);

namespace Core\Services;

class Config
{

    const PATH = __DIR__ .'/../../src/configs/';

    /**
     * @param string $name
     * @return array
     */
    public function get(string $name): array
    {
        return require self::PATH . $name . '.php';
    }

}