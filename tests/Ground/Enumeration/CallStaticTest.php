<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use Ground\Enumeration\AbstractEnumeration;
use Ground\Enumeration\Exception\NotValidEnumerationNameException;
use PHPUnit\Framework\TestCase;

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses
// phpcs:disable Generic.Files.OneClassPerFile.MultipleFound
// phpcs:disable Squiz.Classes.ClassFileName.NoMatch

final class CallStaticTest extends TestCase
{
    public function test(): void
    {
        self::assertEquals(1, TestEnum::one()->getValue());

        self::assertEquals('two', TestEnum::two()->getValue());
    }

    public function testNotValidEnumerationName(): void
    {
        $this->expectException(NotValidEnumerationNameException::class);

        TestEnum::undefinedVal();
    }
}

/**
 * @method bool isOne()
 * @method bool isTwo()
 * @method static static one()
 * @method static static two()
 */
final class TestEnum extends AbstractEnumeration
{
    public const ONE = 1;

    public const TWO = 'two';

    /**
     * {@inheritDoc}
     */
    public static function getValues(): array
    {
        return [
            'one' => self::ONE,
            'two' => self::TWO,
        ];
    }
}

// phpcs:enable
