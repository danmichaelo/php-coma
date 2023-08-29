<?php

declare(strict_types=1);

namespace Danmichaelo\Coma;

use Exception;
use PHPUnit\Framework\TestCase;

class sRGBTest extends TestCase
{
    public function testFromToHex(): void
    {
        $hex = '#234567';
        $c = new sRGB($hex);

        self::assertSame($hex, $c->toHex());
    }

    public function testShortHex(): void
    {
        $hex = '#222';
        $c = new sRGB($hex);

        self::assertSame('#222222', $c->toHex());
    }

    public function testInvalidHexColor1(): void
    {
        self::expectException(Exception::class);

        $hex = '#2222';
        new sRGB($hex);
    }

    public function testInvalidHexColor2(): void
    {
        $hex = '#HHHHHH';
        $c = new sRGB($hex);

        self::assertSame('#000000', $c->toHex());
    }

    public function testInvalidHexColor3(): void
    {
        self::expectException(Exception::class);

        new sRGB(300, 300, 300);
    }

    public function testInverse(): void
    {
        $hex = '#874291';
        $c = new sRGB($hex);

        self::assertSame('#78BD6E', $c->inverse()->toHex());
        self::assertSame($hex, $c->toHex()); // original object should not be altered!
    }
}
