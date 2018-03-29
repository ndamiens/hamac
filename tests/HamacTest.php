<?php
use PHPUnit\Framework\TestCase;
use ND\Hamac\Hamac;
use ND\Hamac\InvalidMacString;

class HamacTest extends TestCase {
	public function  testConversion() {
		$data = [
			["FCD5D916A592",277995400373650],
			["FC:D5:D9:16:A5:92",277995400373650],
			["FC-D5-D9-16-A5-92",277995400373650],
			["FC D5 D9 16 A5 92",277995400373650],
			["FC D5 D9 16 A5 92  ",277995400373650],
			["  FC D5 D9 16 A5 92  ",277995400373650],
			["  FC D5\n D9 16\t A\r5 92  ",277995400373650],
			[strtolower("FC:D5:D9:16:A5:92"),277995400373650],
		];
		foreach ($data as $t) {
			list($hex, $n) = $t;
			$this->assertEquals($n, Hamac::mac2bin($hex), "bad conversion of $hex");
		}
	}

	public function testBadMac1() {
		$this->expectException(InvalidMacString::class);
		Hamac::mac2bin("F916A592");
	}

	public function testBadMac2() {
		$this->expectException(InvalidMacString::class);
		Hamac::mac2bin("FC:D5:D9:16:A5:9Z");
	}

	public function testComp() {
		$tests = [
			["FCD5D916A592","FCD5D916A590","FCD5D916A59F", true],
			["FCD5D916A592","FCD5D916A59F","FCD5D916A590", true],
			["FCD5D916A540","FCD5D916A59F","FCD5D916A590", false],
			["FCD5D916A6A0","FCD5D916A59F","FCD5D916A590", false]
		];
		foreach ($tests as $test) {
			$this->assertEquals(
				$test[3],
				Hamac::isInRange(
					Hamac::mac2bin($test[0]),
					Hamac::mac2bin($test[1]),
					Hamac::mac2bin($test[2])
				)
			);
		}
	}
}
