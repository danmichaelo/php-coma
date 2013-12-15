<?php namespace Danmichaelo\Color;

class ColorDistanceTest extends \PHPUnit_Framework_TestCase {

	protected function setUp() {
		$this->cd = new ColorDistance;
		$this->colors = array(
			new sRGB(1, 5, 250),
			new sRGB(0, 0, 208),
			new sRGB(0, 0, 0),
			new sRGB(255, 255, 255)
		);
	}

	public function testSimple() {
		$de = $this->cd->simpleRgbDistance($this->colors[0], $this->colors[1]);

		$this->assertEquals(9.57912207, $de, '', 0.0001);
	}

	public function testCie76() {
		$de = $this->cd->cie76($this->colors[0], $this->colors[1]);

		$this->assertEquals(17.4763756, $de, '', 0.0001);
	}

	public function testCie94() {
		$de = $this->cd->cie94($this->colors[0], $this->colors[1]);

		$this->assertEquals(6.840347, $de, '', 0.0001);
	}

	public function testMaxDistance() {
		$cie94 = $this->cd->cie94($this->colors[2], $this->colors[3]);
		$cie76 = $this->cd->cie76($this->colors[2], $this->colors[3]);
		$simpl = $this->cd->simpleRgbDistance($this->colors[2], $this->colors[3]);

		$this->assertEquals(100.0, $cie76, '', 0.0001);
		$this->assertEquals(100.0, $cie94, '', 0.0001);
		$this->assertEquals(100.0, $simpl, '', 0.0001);
	}

	public function testNoDistance() {
		$cie94 = $this->cd->cie94($this->colors[2], $this->colors[2]);
		$cie76 = $this->cd->cie76($this->colors[2], $this->colors[2]);
		$simpl = $this->cd->simpleRgbDistance($this->colors[2], $this->colors[2]);

		$this->assertEquals(0.0, $cie76, '', 0.0001);
		$this->assertEquals(0.0, $cie94, '', 0.0001);
		$this->assertEquals(0.0, $simpl, '', 0.0001);
	}
}
