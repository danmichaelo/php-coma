<?php

namespace Danmichaelo\Coma;

class XYZ
{
    public $x;
    public $y;
    public $z;
    private $white;

    public function __construct($x, $y, $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;

        //  CIE XYZ tristimulus values of the reference white point
        $this->white = array('x' => 0.95047, 'y' => 1.0000, 'z' => 1.08883);
    }

    protected function pivot($n)
    {
        return ($n > 0.008856)
            ? pow($n, 1.0 / 3.0)         // (6./29)**3 = 0.008856   or 216/24389
            : 7.78703 * $n + 0.13793;  // (1./3) * (29./6)**2 * t + 4./29
    }

    protected function pivotAlternative($t)
    {
        if ($t > 0.008856) {  // (6./29)**3 = 0.008856   or 216/24389
            return pow($t, 1.0 / 3.0);
        } else {
            return (903.3 * $t + 16) / 116;
        }
    }

    public function toLab()
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
            max(array(0, 116 * $y - 16)),
            500 * ($x - $y),
            200 * ($y - $z)
        );
    }
}
