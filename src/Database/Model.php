<?php

namespace Amrudinbalic\Marketplace\Database;

use PDO;

class Model
{
    protected PDO $pdo;
    public function __construct()
    {
        global $container;
        $this->pdo = $container->get(PDO::class);
    }
}