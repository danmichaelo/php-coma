<?php namespace Danmichaelo\Color;

class sRGB
{
	public $r;
	public $g;
	public $b;

	function __construct($r, $g = null, $b = null)
	{
		if (is_null($g) && is_null($b)) {
			$this->fromHex($r);
		} else {
			$this->r = $r;
			$this->g = $g;
			$this->b = $b;
		}
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

	public function toHex()
	{
		$hex = '#';
		$hex .= strtoupper(str_pad(dechex($this->r), 2, '0', STR_PAD_LEFT));
		$hex .= strtoupper(str_pad(dechex($this->g), 2, '0', STR_PAD_LEFT));
		$hex .= strtoupper(str_pad(dechex($this->b), 2, '0', STR_PAD_LEFT));
		return $hex;
	}

	protected function fromHex($hex) {
		$hex = str_replace('#', '', $hex);

		if (strlen($hex) == 3) {
			$this->r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
			$this->g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
			$this->b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));

		} else if (strlen($hex) == 6) {
			$this->r = hexdec(substr($hex, 0, 2));
			$this->g = hexdec(substr($hex, 2, 2));
			$this->b = hexdec(substr($hex, 4, 2));

		} else {
			throw new Exception('Invalid hex color code length');
		}
	}

}
