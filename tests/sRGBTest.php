<?php namespace Danmichaelo\Color;

class sRGBTest extends \PHPUnit_Framework_TestCase {

	public function testFromToHex() {
		$hex = '#234567';
		$c = new sRGB($hex);

		$this->assertEquals($hex, $c->toHex());
	}

}
