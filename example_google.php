<?php

require "../vendor/autoload.php";

use yswery\DNS\Server;
use yswery\DNS\GoogleResolver;

// Creating a new instance of our class
$dns = new Server((new GoogleResolver()));

try {
    // Starting our DNS server
    $dns->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}