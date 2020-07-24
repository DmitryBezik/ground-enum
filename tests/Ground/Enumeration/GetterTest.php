<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use Ground\Enumeration\Exception\DuplicateValuesException;
use Ground\Enumeration\Exception\NotAllStringOrIntValuesTypeException;
use Ground\Enumeration\Exception\NotValidEnumerationValueException;
use PHPUnit\Framework\TestCase;

final class GetterTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @param int|string $value
     * @param int|string $expected
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     * @throws NotValidEnumerationValueException
     */
    public function test($value, $expected): void
    {
        self::assertEquals($expected, (new TestEnum($value))->getValue());
    }

    /**
     * @return mixed[][]
     */
    public function dataProvider(): array
    {
        return
            [
                'ONE' =>
                    [
                        'value' => 1,
                        'expected' => 1,
                    ],
                'TWO' =>
                    [
                        'value' => 'two',
                        'expected' => 'two',
                    ],
            ];
    }
}
