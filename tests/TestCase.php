<?php

use \yswery\DNS\RecordTypeEnum;

abstract class TestCase extends PHPUnit_Framework_TestCase {
    
    /**
     * Loads and returns test binary buffer content for a given
     * record type and domain.
     * 
     * @param string $type      'A' or 'MX' or 'NS' or any valid record type name, uppercase.
     * @param string $domain    Any domain for which a test buffer exists under /tests/buffers
     * @return bool
     */
    protected function getBuffer($type, $domain)
    {
        $bufferPath = __DIR__ . "/buffers/%s/%s";
        if(false === RecordTypeEnum::get_type_index($type)) return false;
        $path = sprintf($bufferPath, $type, $domain);
        if(!file_exists($path)) return false;
        return file_get_contents($path);
    }
    
}
