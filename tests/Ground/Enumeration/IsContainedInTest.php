<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use PHPUnit\Framework\TestCase;
use stdClass;

final class IsContainedInTest extends TestCase
{
    public function testHasName(): void
    {
        $obj = TestEnum::createByName('one');
        $obj2 = TestEnum::createByName('one');
        $obj3 = TestEnum::createByName('two');
        $obj4 = TestEnum::createByName('two');
        $obj5 = new stdClass();

        $this->assertTrue($obj->isContainedIn([$obj]));
        $this->assertTrue($obj->isContainedIn([$obj, $obj2]));
        $this->assertTrue($obj->isContainedIn([$obj2, $obj3]));
        $this->assertFalse($obj->isContainedIn([$obj3, $obj4]));
        $this->assertFalse($obj->isContainedIn([$obj3]));
        $this->assertFalse($obj->isContainedIn([$obj5]));
    }
}
