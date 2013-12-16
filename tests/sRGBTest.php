<?php namespace Danmichaelo\Color;

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
	public function testWrongLength() {
		$hex = '#2222';
		$c = new sRGB($hex);
	}

}
