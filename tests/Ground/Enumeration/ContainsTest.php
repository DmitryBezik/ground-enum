<?php

declare(strict_types=1);

namespace Tests\Ground\Enumeration;

use PHPUnit\Framework\TestCase;

final class ContainsTest extends TestCase
{
    public function test(): void
    {
        $this->assertTrue(TestEnum::contains(1));
        $this->assertTrue(TestEnum::contains('two'));
        $this->assertFalse(TestEnum::contains('undefined'));
    }
}
