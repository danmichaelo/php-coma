<?php namespace Danmichaelo\Coma;

/**
 * References used:
 * - https://en.wikipedia.org/wiki/Color_difference
 * - https://en.wikipedia.org/wiki/Lab_color_space
 * - https://en.wikipedia.org/wiki/SRGB_color_space
 * - https://github.com/THEjoezack/ColorMine (.NET example code)
 * - https://gist.github.com/mikelikespie/641528 (JS example code)
 */

class ColorDistance {

	protected function toLab($color)
	{
		if ($color instanceof Lab) {
			return $color;
		}
		if ($color instanceof sRGB) {
			return $color->toLab();
		}
		throw new \Exception('color of unknown class');
		// Finnes det noe ala InvalidArgumentException?
	}

	/**
	 * DeltaE calculation using the CIE76 formula.
	 * Delta = 2.3 corresponds to a just noticeable difference
	 *
	 * 1. assume that your RGB values are in the sRGB colorspace
	 * 2. convert sRGB colors to L*a*b*
	 * 3. compute deltaE between your two L*a*b* values.
	 */
	public function cie76($color1, $color2)
	{
		$f1 = $this->toLab($color1);
		$f2 = $this->toLab($color2);

		$deltaL = $f2->l - $f1->l;
		$deltaA = $f2->a - $f1->a;
		$deltaB = $f2->b - $f1->b;

		$deltaE = $deltaL*$deltaL + $deltaA*$deltaA + $deltaB*$deltaB;

		return $deltaE < 0 ? 0 : sqrt($deltaE);
	}

	/**
	 * DeltaE calculation using the CIE94 formula.
	 * Delta = 2.3 corresponds to a just noticeable difference
	 */
	public function cie94($color1, $color2)
	{

		$Kl = 1.0;
		$K1 = .045;
		$K2 = 0.015;

		$Kc = 1.0;
		$Kh = 1.0;

		$f1 = $this->toLab($color1);
		$f2 = $this->toLab($color2);

		$deltaL = $f2->l - $f1->l;
		$deltaA = $f2->a - $f1->a;
		$deltaB = $f2->b - $f1->b;

		$c1 = sqrt($f1->a * $f1->a + $f1->b * $f1->b);
		$c2 = sqrt($f2->a * $f2->a + $f2->b * $f2->b);
		$deltaC = $c2 - $c1;

		$deltaH = $deltaA * $deltaA + $deltaB * $deltaB - $deltaC * $deltaC;
		$deltaH = $deltaH < 0 ? 0 : sqrt($deltaH);

		$Sl = 1.0;
		$Sc = 1 + $K1 * $c1;
		$Sh = 1 + $K2 * $c1;

		$deltaLKlsl = $deltaL / ($Kl * $Sl);
		$deltaCkcsc = $deltaC / ($Kc * $Sc);
		$deltaHkhsh = $deltaH / ($Kh * $Sh);

		$deltaE = $deltaLKlsl * $deltaLKlsl + $deltaCkcsc * $deltaCkcsc + $deltaHkhsh * $deltaHkhsh;

		return $deltaE < 0 ? 0 : sqrt($deltaE);
	}

	/**
	 * Not very useful, but interesting to compare
	 */
	public function simpleRgbDistance($color1, $color2)
	{
		$deltaR = ($color2->r - $color1->r) / 255;
		$deltaG = ($color2->g - $color1->g) / 255;
		$deltaB = ($color2->b - $color1->b) / 255;
		$deltaE = $deltaR * $deltaR + $deltaG * $deltaG + $deltaB * $deltaB;

		return ($deltaE < 0)
			? $deltaE
			: sqrt($deltaE) * 57.73502691896258;  //  / sqrt(3) * 100;
	}

}
