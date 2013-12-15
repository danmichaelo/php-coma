ColorDistance
===============

[![Build Status](https://travis-ci.org/danmichaelo/colordistance.png?branch=master)](https://travis-ci.org/danmichaelo/colordistance)
[![Coverage Status](https://coveralls.io/repos/danmichaelo/colordistance/badge.png?branch=master)](https://coveralls.io/r/danmichaelo/colordistance?branch=master)
[![Latest Stable Version](https://poser.pugx.org/danmichaelo/colordistance/version.png)](https://packagist.org/packages/danmichaelo/colordistance)
[![Total Downloads](https://poser.pugx.org/danmichaelo/colordistance/downloads.png)](https://packagist.org/packages/danmichaelo/colordistance)


Simple class to calculate various [color distance metrics](https://en.wikipedia.org/wiki/Color_difference) (delta E). Currently CIE76 and CIE94 are implemented, but I plan to implement more.

```php
use Danmichaelo\Color\ColorDistance,
	Danmichaelo\Color\sRGB;

$color1 = new sRGB(1, 5, 250);
$color2 = new sRGB(0, 0, 208);

$cd = new ColorDistance;
$cie94 = $cd->cie94($color1, $color2);
echo 'The CIE94 ∆E is ' . $cie94 . ' between ' . $color1->toHex() . ' and ' . $color2->toHex() . '.';
```
