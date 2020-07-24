<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use Ground\Enumeration\AbstractEnumeration;
use Ground\Enumeration\Exception\DuplicateValuesException;
use Ground\Enumeration\Exception\NotAllStringOrIntValuesTypeException;
use Ground\Enumeration\Exception\NotValidEnumerationNameException;
use Ground\Enumeration\Exception\NotValidEnumerationValueException;
use PHPUnit\Framework\TestCase;

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound
// phpcs:disable Squiz.Classes.ClassFileName.NoMatch

final class ConstructTest extends TestCase
{
    /**
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    public function testNotValidEnumerationValue(): void
    {
        $this->expectException(NotValidEnumerationValueException::class);

        new TestEnum('undefinedVal');
    }

    /**
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    public function testCreateByValue(): void
    {
        self::assertEquals(1, TestEnum::createByValue(1)->getValue());

        self::assertEquals('two', TestEnum::createByValue('two')->getValue());
    }

    /**
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    public function testCreateByValueNotValidEnumerationValue(): void
    {
        $this->expectException(NotValidEnumerationValueException::class);

        TestEnum::createByValue('undefinedVal');
    }

    /**
     * @throws NotValidEnumerationNameException
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    public function testCreateByName(): void
    {
        self::assertEquals(1, TestEnum::createByName('one')->getValue());

        self::assertEquals('two', TestEnum::createByName('two')->getValue());
    }

    /**
     * @throws NotValidEnumerationNameException
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    public function testCreateByNameNotValidEnumerationName(): void
    {
        $this->expectException(NotValidEnumerationNameException::class);

        TestEnum::createByName('undefinedConst');
    }

    /**
     * @throws NotValidEnumerationNameException
     * @throws NotValidEnumerationValueException
     * @throws DuplicateValuesException
     * @throws NotAllStringOrIntValuesTypeException
     */
    public function testIsUniqueValues(): void
    {
        $this->expectException(DuplicateValuesException::class);

        TestEnumDuplicate::createByName('one');
    }

    public function testIsValuesStringOrInt(): void
    {
        $this->expectException(NotAllStringOrIntValuesTypeException::class);

        TestEnumValuesNotIntAndString::createByName('one');
    }

    public function testTryCreateByValue(): void
    {
        self::assertEquals(TestEnum::one(), TestEnum::tryCreateByValue(1));

        self::assertEquals(null, TestEnum::tryCreateByValue('three'));
    }
}

final class TestEnumDuplicate extends AbstractEnumeration
{
    public const ONE = 1;

    /**
     * {@inheritDoc}
     */
    public static function getValues(): array
    {
        return [
            'one' => self::ONE,
            'two' => self::ONE,
        ];
    }
}

final class TestEnumValuesNotIntAndString extends AbstractEnumeration
{
    public const ONE = 1;

    /**
     * {@inheritDoc}
     */
    public static function getValues(): array
    {
        return [
            'one' => 1.4555,
            'two' => 1.234,
        ];
    }
}

// phpcs:enable
