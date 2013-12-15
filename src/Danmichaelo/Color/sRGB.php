<?php namespace Danmichaelo\Color;

class sRGB
{
	public $r;
	public $g;
	public $b;

	function __construct($r, $g, $b)
	{
		$this->r = $r;
		$this->g = $g;
		$this->b = $b;
	}

	protected function pivot($n)
	{
		return ($n > 0.04045)
			? pow(($n + 0.055) / (1 + 0.055), 2.4)
			: $n / 12.92;
	}

	/**
	 * The reverse transformation (sRGB to CIE XYZ)
	 * https://en.wikipedia.org/wiki/SRGB
	 */
	public function toXyz()
	{

		// Reverse transform from sRGB to XYZ:
		$color = array(
			$this->pivot($this->r / 255),
			$this->pivot($this->g / 255),
			$this->pivot($this->b / 255)
		);

		// Observer = 2°, Illuminant = D65
		return new XYZ(
			$color[0] * 0.412453 + $color[1] * 0.357580 + $color[2] * 0.180423,
			$color[0] * 0.212671 + $color[1] * 0.715160 + $color[2] * 0.072169,
			$color[0] * 0.019334 + $color[1] * 0.119193 + $color[2] * 0.950227
		);
	}

	public function toLab()
	{
		// Reverse transform from sRGB to XYZ
		$xyz = $this->toXyz();

		// Forward transform from XYZ to CIE LAB
		return $xyz->toLab();
	}

}
