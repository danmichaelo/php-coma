<?php namespace Danmichaelo\Coma;

class sRGBTest extends \PHPUnit_Framework_TestCase {

	public function testFromToHex() {
		$hex = '#234567';
		$c = new sRGB($hex);

		$this->assertEquals($hex, $c->toHex());
	}

	public function testShortHex() {
		$hex = '#222';
		$c = new sRGB($hex);

		$this->assertEquals('#222222', $c->toHex());
	}

	/**
	 * @expectedException Exception
	 */
	public function testInvalidHexColor1() {
		$hex = '#2222';
		$c = new sRGB($hex);
	}


	public function testInvalidHexColor2() {
		$hex = '#HHHHHH';
		$c = new sRGB($hex);

		$this->assertEquals('#000000', $c->toHex());
	}

	/**
	 * @expectedException Exception
	 */
	public function testInvalidHexColor3() {
		$c = new sRGB(300, 300, 300);
	}
}
