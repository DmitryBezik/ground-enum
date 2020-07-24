<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use Ground\Enumeration\Exception\DuplicateValuesException;
use Ground\Enumeration\Exception\NotAllStringOrIntValuesTypeException;
use Ground\Enumeration\Exception\NotValidEnumerationNameException;
use Ground\Enumeration\Exception\NotValidEnumerationValueException;
use PHPUnit\Framework\TestCase;

final class ToStringTest extends TestCase
{
    /**
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     * @throws NotValidEnumerationNameException
     * @throws NotValidEnumerationValueException
     */
    public function testEq(): void
    {
        $this->assertSame('1', (string)TestEnum::createByValue(1));
    }
}
