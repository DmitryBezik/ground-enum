<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use PHPUnit\Framework\TestCase;

final class GetNameTest extends TestCase
{
    public function testGetName(): void
    {
        $obj = TestEnum::createByName('one');
        $this->assertEquals('one', $obj->getName());

        $obj = TestEnum::createByName('two');
        $this->assertEquals('two', $obj->getName());
    }
}
