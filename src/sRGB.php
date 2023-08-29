<?php

declare(strict_types=1);

namespace Danmichaelo\Coma;

use Exception;

use function dechex;
use function hexdec;
use function is_null;
use function is_numeric;
use function is_string;
use function pow;
use function str_pad;
use function str_replace;
use function strlen;
use function strtoupper;
use function substr;

class sRGB
{
    /**
     * Red value in range 0,255.
     *
     */
    public int $r;

    /**
     * Green value in range 0,255.
     */
    public int $g;

    /**
     * Blue value in range 0,255.
     */
    public int $b;

    public function __construct(int|string $r, ?int $g = null, ?int $b = null)
    {
        if (is_string($r) && is_null($g) && is_null($b)) {
            $this->fromHex($r);
        } else {
            if (!is_numeric($r) || $r < 0 || $r > 255) {
                throw new Exception('red out of range');
            }
            if (!is_numeric($g) || $g < 0 || $g > 255) {
                throw new Exception('green out of range');
            }
            if (!is_numeric($b) || $b < 0 || $b > 255) {
                throw new Exception('blue out of range');
            }

            $this->r = (int) $r;
            $this->g = (int) $g;
            $this->b = (int) $b;
        }
    }

    protected function pivot(float $n): float
    {
        return ($n > 0.04045)
            ? pow(($n + 0.055) / (1 + 0.055), 2.4)
            : $n / 12.92;
    }

    /**
     * The reverse transformation (sRGB to CIE XYZ)
     * https://en.wikipedia.org/wiki/SRGB.
     */
    public function toXyz(): XYZ
    {

        // Reverse transform from sRGB to XYZ:
        $color = [
            $this->pivot($this->r / 255),
            $this->pivot($this->g / 255),
            $this->pivot($this->b / 255),
        ];

        // Observer = 2°, Illuminant = D65
        return new XYZ(
            $color[0] * 0.412453 + $color[1] * 0.357580 + $color[2] * 0.180423,
            $color[0] * 0.212671 + $color[1] * 0.715160 + $color[2] * 0.072169,
            $color[0] * 0.019334 + $color[1] * 0.119193 + $color[2] * 0.950227
        );
    }

    public function toLab(): Lab
    {
        // Reverse transform from sRGB to XYZ
        $xyz = $this->toXyz();

        // Forward transform from XYZ to CIE LAB
        return $xyz->toLab();
    }

    public function toHex(): string
    {
        $hex = '#';
        $hex .= strtoupper(str_pad(dechex($this->r), 2, '0', STR_PAD_LEFT));
        $hex .= strtoupper(str_pad(dechex($this->g), 2, '0', STR_PAD_LEFT));
        $hex .= strtoupper(str_pad(dechex($this->b), 2, '0', STR_PAD_LEFT));

        return $hex;
    }

    protected function fromHex(string $hex): void
    {
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) == 3) {
            $this->r = (int) @hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $this->g = (int) @hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $this->b = (int) @hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } elseif (strlen($hex) == 6) {
            $this->r = (int) @hexdec(substr($hex, 0, 2));
            $this->g = (int) @hexdec(substr($hex, 2, 2));
            $this->b = (int) @hexdec(substr($hex, 4, 2));
        } else {
            throw new Exception('Invalid hex color code length');
        }
    }

    /**
     * Returns the inverse of the current color.
     */
    public function inverse(): self
    {
        return new self(255 - $this->r, 255 - $this->g, 255 - $this->b);
    }
}
