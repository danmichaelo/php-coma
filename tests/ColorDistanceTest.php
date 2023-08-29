<?php

declare(strict_types=1);

namespace Danmichaelo\Coma;

use Exception;
use PHPUnit\Framework\TestCase;

class ColorDistanceTest extends TestCase
{
    protected function setUp(): void
    {
        $this->cd = new ColorDistance();
        $this->colors = [
            new sRGB(1, 5, 250),
            new sRGB(0, 0, 208),
            new sRGB(0, 0, 0),
            new sRGB(255, 255, 255),
        ];
    }

    public function testSimple(): void
    {
        $de = $this->cd->simpleRgbDistance($this->colors[0], $this->colors[1]);

        self::assertEqualsWithDelta(9.57912207, $de, 0.0001);
    }

    public function testCie76(): void
    {
        $de = $this->cd->cie76($this->colors[0], $this->colors[1]);

        self::assertEqualsWithDelta(17.4763756, $de, 0.0001);
    }

    public function testCie94(): void
    {
        $de = $this->cd->cie94($this->colors[0], $this->colors[1]);

        self::assertEqualsWithDelta(6.840347, $de, 0.0001);
    }

    public function testMaxDistance(): void
    {
        $cie94 = $this->cd->cie94($this->colors[2], $this->colors[3]);
        $cie76 = $this->cd->cie76($this->colors[2], $this->colors[3]);
        $simpl = $this->cd->simpleRgbDistance($this->colors[2], $this->colors[3]);

        self::assertEqualsWithDelta(100.0, $cie76, 0.0001);
        self::assertEqualsWithDelta(100.0, $cie94, 0.0001);
        self::assertEqualsWithDelta(100.0, $simpl, 0.0001);
    }

    public function testNoDistance(): void
    {
        $cie94 = $this->cd->cie94($this->colors[2], $this->colors[2]);
        $cie76 = $this->cd->cie76($this->colors[2], $this->colors[2]);
        $simpl = $this->cd->simpleRgbDistance($this->colors[2], $this->colors[2]);

        self::assertEqualsWithDelta(0.0, $cie76, 0.0001);
        self::assertEqualsWithDelta(0.0, $cie94, 0.0001);
        self::assertEqualsWithDelta(0.0, $simpl, 0.0001);
    }

    public function testInvalidArgument(): void
    {
        self::expectException(Exception::class);

        $this->cd->cie94(1, 2);
    }
}
