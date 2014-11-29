<?php

use Symfony\Component\Process\Process;
use yswery\DNS\RecordTypeEnum;

class ServerTest extends TestCase {

    /**
     * @var Symfony\Component\Process\Process
     */
    protected $process;

    protected function startServer()
    {
        $path = realpath(__DIR__ . '/utils/serve-json.php');
        $this->process = new Process("php $path");
        $this->process->start();
        $this->assertTrue($this->process->isStarted());
        echo PHP_EOL . "Started server with PID {$this->process->getPid()}" . PHP_EOL;
    }

    protected function killServer()
    {
        echo PHP_EOL . "Stopping server with PID {$this->process->getPid()}" . PHP_EOL;
        //exec('kill -9 ' . $this->process->getPid());
        $this->process->stop();
        sleep(1);
    }

    public function testResolution()
    {
        $this->startServer();
        $socket = fsockopen('udp://0.0.0.0', 53, $errno, $error);
        $this->assertNotFalse($socket);
        if(!$socket)
        {
            echo "Error: $error" . PHP_EOL;
            return;
        }
        $timeout = 5;
        socket_set_timeout($socket, $timeout);
        $buffer = $this->getBuffer(RecordTypeEnum::TYPE_A, 'test.com');
        $maxlen = 1024;
        fwrite($socket, $buffer, $maxlen);
        var_dump(fread($socket, $maxlen));
        fclose($socket);
        $this->killServer();
    }
    
}
