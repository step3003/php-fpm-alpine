<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

class GDModuleTest extends TestCase
{
    public function test_is_module_loaded()
    {
        $this->assertTrue(extension_loaded('gd'));
    }
    
    public function test_is_format_supported()
    {
        $info = gd_info();
    
        $this->assertTrue($info['FreeType Support'], 'Freetype support active');
        $this->assertTrue($info['JPEG Support'], 'JPEG support active');
        $this->assertTrue($info['PNG Support'], 'PNG support active');
        $this->assertTrue($info['WebP Support'], 'WebP support active');
        $this->assertTrue($info['AVIF Support'], 'AVIF support active');
    }
}