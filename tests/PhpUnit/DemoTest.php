<?php

namespace App\Tests\PhpUnit;

use PHPUnit\Framework\TestCase;

class DemoTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testFramework()
    {
        $this->assertTrue(true);
    }
}
