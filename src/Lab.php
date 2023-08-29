<?php

declare(strict_types=1);

namespace Danmichaelo\Coma;

class Lab
{
    public float $l;
    public float $a;
    public float $b;

    public function __construct(float $l, float $a, float $b)
    {
        $this->l = $l;
        $this->a = $a;
        $this->b = $b;
    }
}
