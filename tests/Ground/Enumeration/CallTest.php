<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use BadMethodCallException;
use Ground\Enumeration\Exception\NotValidEnumerationNameException;
use PHPUnit\Framework\TestCase;

final class CallTest extends TestCase
{
    public function test(): void
    {
        $obj = TestEnum::createByName('one');
        $this->assertTrue($obj->isOne());
        $this->assertFalse($obj->isTwo());

        $obj = TestEnum::createByName('two');
        $this->assertTrue($obj->isTwo());
        $this->assertFalse($obj->isOne());
    }

    public function testNotValidEnumerationName(): void
    {
        $this->expectException(NotValidEnumerationNameException::class);

        TestEnum::createByName('two')->isUndefinedName();
    }

    public function testBadMethodCallException(): void
    {
        $this->expectException(BadMethodCallException::class);

        $obj = TestEnum::createByName('two');
        $obj->undefinedMethod();
    }
}
