CoMa – PHP Color Math Library
===============

[![Build Status](https://travis-ci.org/danmichaelo/php-coma.png?branch=master)](https://travis-ci.org/danmichaelo/php-coma)
[![Coverage Status](https://coveralls.io/repos/danmichaelo/php-coma/badge.png?branch=master)](https://coveralls.io/r/danmichaelo/php-coma?branch=master)
[![Latest Stable Version](https://poser.pugx.org/danmichaelo/php-coma/version.png)](https://packagist.org/packages/danmichaelo/php-coma)
[![Total Downloads](https://poser.pugx.org/danmichaelo/php-coma/downloads.png)](https://packagist.org/packages/danmichaelo/php-coma)

Php library to convert between [sRGB](//en.wikipedia.org/wiki/SRGB), [XYZ](//en.wikipedia.org/wiki/XYZ_color_space), and [Lab](//en.wikipedia.org/wiki/Lab_color_space) color spaces, and calculate various [color distance metrics](//en.wikipedia.org/wiki/Color_difference) (delta E). Currently CIE76 and CIE94 are implemented, but I plan to implement more.

```php
use Danmichaelo\Coma\ColorDistance,
	Danmichaelo\Coma\sRGB;

$color1 = new sRGB(1, 5, 250);
$color2 = new sRGB(0, 0, 208);

$cd = new ColorDistance;
$cie94 = $cd->cie94($color1, $color2);
echo 'The CIE94 ∆E is ' . $cie94 . ' between ' . $color1->toHex() . ' and ' . $color2->toHex() . '.';
```
