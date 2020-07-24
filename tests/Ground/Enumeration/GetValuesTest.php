<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use PHPUnit\Framework\TestCase;

final class GetValuesTest extends TestCase
{
    public function test(): void
    {
        $this->assertEquals(
            [
                'one' => 1,
                'two' => 'two',
            ],
            TestEnum::getValues()
        );
    }
}
