<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

class RedisModuleTest extends TestCase
{
    public function test_is_module_loaded()
    {
        $this->assertTrue(extension_loaded('redis'));
    }
    
    public function test_is_compression_and_serialization_modules_available()
    {
        $result = trim(shell_exec('php --ri redis'));
        
        $this->assertStringContainsString('igbinary', $result);
        $this->assertStringContainsString('zstd', $result);
    }
    
    public function test_connection()
    {
        $redis = new Redis();
        
        try {
            $connectionResult = $redis->connect(host: 'redis');
        } catch (RedisException) {
            $connectionResult = false;
        }
        $this->assertTrue($connectionResult);
        $this->assertTrue($redis->ping());
    
        $redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_IGBINARY);
        $redis->setOption(Redis::OPT_COMPRESSION, Redis::COMPRESSION_ZSTD);
        
        $data = array_map(fn () => rand(1, 100), range(0, 50));
        $key = 'test';
    
        $redis->set($key, serialize($data));
        $receiveData = unserialize($redis->get($key));
    
        $this->assertEquals($receiveData, $data);
    }
}
