<?php

declare(strict_types=1);

namespace Danmichaelo\Coma;

use function max;
use function pow;

class XYZ
{
    public float $x;
    public float $y;
    public float $z;

    /**
     * @var array{'x': float, 'y': float, 'z': float}
     */
    private array $white;

    public function __construct(float $x, float $y, float $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;

        //  CIE XYZ tristimulus values of the reference white point
        $this->white = ['x' => 0.95047, 'y' => 1.0000, 'z' => 1.08883];
    }

    protected function pivot(float $n): float
    {
        return ($n > 0.008856)
            ? pow($n, 1.0 / 3.0)         // (6./29)**3 = 0.008856   or 216/24389
            : 7.78703 * $n + 0.13793;  // (1./3) * (29./6)**2 * t + 4./29
    }

    protected function pivotAlternative(float $t): float
    {
        if ($t > 0.008856) {  // (6./29)**3 = 0.008856   or 216/24389
            return pow($t, 1.0 / 3.0);
        } else {
            return (903.3 * $t + 16) / 116;
        }
    }

    public function toLab(): Lab
    {
        $color = array(
            $this->x / $this->white['x'],
            $this->y / $this->white['y'],
            $this->z / $this->white['z'],
        );

        $x = $this->pivot($color[0]);
        $y = $this->pivot($color[1]);
        $z = $this->pivot($color[2]);

        return new Lab(
            max(0, 116 * $y - 16),
            500 * ($x - $y),
            200 * ($y - $z)
        );
    }
}
