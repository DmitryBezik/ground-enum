<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use Ground\Enumeration\Exception\DuplicateValuesException;
use Ground\Enumeration\Exception\NotAllStringOrIntValuesTypeException;
use Ground\Enumeration\Exception\NotValidEnumerationNameException;
use Ground\Enumeration\Exception\NotValidEnumerationValueException;
use PHPUnit\Framework\TestCase;

final class EqTest extends TestCase
{
    /**
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     * @throws NotValidEnumerationNameException
     * @throws NotValidEnumerationValueException
     */
    public function testEq(): void
    {
        $this->assertTrue(TestEnum::createByValue(1)->eq(TestEnum::createByValue(1)));
        $this->assertTrue(TestEnum::createByValue('two')->eq(TestEnum::createByName('two')));
        $this->assertFalse(TestEnum::createByValue(1)->eq(TestEnum::createByName('two')));
    }
}
