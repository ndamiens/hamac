<?php
namespace ND\Hamac;

class Hamac {
	/**
	 * convert mac string to bin
	 */
	const ASCII_0 = 48;
	const ASCII_9 = 57;
	const ASCII_A = 65;
	const ASCII_F = 70;

	/**
	 * convert mac string to integer
	 * @param string $mac
	 * @return integer
	 */
	public static function mac2bin(string $mac) {
		$mac = strtoupper($mac);
		$clean_mac = "";
		foreach (str_split($mac) as $frag) {
			$n = ord($frag);
			if (($n >= self::ASCII_A && $n <= self::ASCII_F) || ($n >= self::ASCII_0 && $n <= self::ASCII_9)) {
				$clean_mac .= $frag;
			}
		}
		if (strlen($clean_mac) != 12) {
			throw new InvalidMacString("$mac len=".strlen($clean_mac));
		}
		return hexdec($clean_mac);
	}

	/**
	 * test mac in range
	 * @param integer $mac test mac
	 * @param integer $mac1 first mac
	 * @param integer $mac2 last mac
	 * @return boolean
	 */
	public static function isInRange(int $mac, int $mac1, int $mac2) {
		return ($mac >= min($mac1,$mac2) && $mac <= max($mac1,$mac2));
	}
}
