<?php

declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

class PostgresModuleTest extends TestCase
{
    public function test_is_module_loaded()
    {
        $this->assertTrue(extension_loaded('pdo_pgsql'));
    }
    
    public function test_connection()
    {
        $dsn = "pgsql:host=db;port=5432;dbname=postgres;";
    
        try {
            $pdo = new PDO($dsn, 'postgres', 'postgres', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        } catch (PDOException) {
            $pdo = null;
        }
        
        $this->assertInstanceOf(PDO::class, $pdo);
    
        $pdo->beginTransaction();
        try {
            $pdo->exec(<<< SQL
                create table test(id bigserial PRIMARY KEY, name varchar(255))
            SQL);
            
            $pdo->exec(<<<SQL
                insert into test(name) values ('test_row')
            SQL);
            
            $prepared = $pdo->prepare(<<<SQL
                select name from test
            SQL);
    
            $prepared->execute();
            
            ['name' => $name] = $prepared->fetch(PDO::FETCH_ASSOC);
            
            $this->assertEquals('test_row', $name);
        }
        finally {
            $pdo->rollBack();
        }
    }
}
