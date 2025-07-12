<?php

// app services aliases
use Amrudinbalic\Marketplace\Database\Connect as DatabaseConnect;

// database connection
$connect = new DatabaseConnect();
$pdo = $connect->getConnection();