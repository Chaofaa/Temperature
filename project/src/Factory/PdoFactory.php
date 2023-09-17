<?php

namespace Factory;

use PDO;

class PdoFactory
{

    public static function create(string $config): PDO
    {
        $instance = new PDO($config);
        $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $instance;
    }

}
