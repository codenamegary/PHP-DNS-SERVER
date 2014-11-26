<?php

use \yswery\DNS\Server;
use \yswery\DNS\JsonStorageProvider;

class ServerTest extends TestCase {
    
    /**
     * @var yswery\DNS\Server
     */
    protected $server;
    
    public function setUp()
    {
        $storage = new JsonStorageProvider(__DIR__ . '/test_records.json');
        $this->server = new Server($storage);
    }
    
    public function testStart()
    {
        $this->server->start();
        
    }
    
}
