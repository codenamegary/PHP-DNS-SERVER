<?php

function log_error($message)
{
    $f = fopen(__DIR__ . '/serve-json.log', 'a');
    $date = gmdate('Y-m-d H:i:s | ');
    fwrite($f, $date . $message . PHP_EOL);
    fclose($f);
}

pcntl_signal(SIGKILL, function(){
    exit(1);
});

set_error_handler(function($error_level, $error_message, $error_file, $error_line){
    log_error($error_message);
});

set_exception_handler(function($exception){
    log_error('EXCEPTION: ' . $exception->getMessage());
});

register_shutdown_function(function() {
    $error = error_get_last();
    if($error !== NULL){
        $info = "[SHUTDOWN] file:".$error['file']." | ln:".$error['line']." |    msg:".$error['message'];
        log_error($info);
    }
    else{
        log_error('Shutdown with no errors.');
    }
});

$autoloader = realpath(__DIR__ . '/../../vendor/autoload.php');
require $autoloader;

use yswery\DNS\JsonStorageProvider;
use yswery\DNS\Server;

$storage = new JsonStorageProvider(__DIR__ . '/test_records.json');
$server = new Server($storage);
$server->start();
