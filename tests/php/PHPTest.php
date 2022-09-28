<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

class PHPTest extends TestCase
{
    public function test_if_doesnt_have_warnings()
    {
        $result = trim(shell_exec('php -m'));
        
        $this->assertStringNotContainsString('Warning', $result);
    }
}
