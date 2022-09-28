<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

class ImagickModuleTest extends TestCase
{
    public function test_is_module_loaded()
    {
        $this->assertTrue(extension_loaded('imagick'));
    }
    
    public function test_is_format_supported()
    {
        $imagick = new Imagick();
        $imagick->newImage(1, 1, new ImagickPixel('#000000'));
        $imagick->setImageFormat('png');
        
        $this->assertIsString($imagick->getImageBlob());
    }
}