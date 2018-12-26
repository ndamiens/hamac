<?php
namespace ND\Hamac;

class Hamac {
	const ASCII_0 = 48;
	const ASCII_9 = 57;
	const ASCII_A = 65;
	const ASCII_F = 70;
	const ASCII_DELIM = [32,45,46,58,59];
	const MAC_LEN = 12;

	protected $mac;

	public function __construct($mac_string) {
		$this->mac = $mac_string;
		// validate string
		self::mac2bin($mac_string);
	}

	public function __toString() {
		return self::bin2mac(self::mac2bin($this->mac));
	}

	public static function bin2mac($mac_bin) {
		$tr = [];
		$s = str_pad(dechex($mac_bin), self::MAC_LEN, "0", STR_PAD_LEFT);
		for ($i=0; $i<self::MAC_LEN; $i+=2) {
			$tr[] = $s[$i].$s[$i+1];
		}
		return strtolower(join(":",$tr));
	}

	/**
	 * convert mac string to integer
	 * @param string $mac
	 * @return integer
	 */
	public static function mac2bin($mac) {
		$mac = strtoupper($mac);
		$clean_mac = "";
		foreach (str_split($mac) as $frag) {
			$n = ord($frag);
			if (($n >= self::ASCII_A && $n <= self::ASCII_F) || ($n >= self::ASCII_0 && $n <= self::ASCII_9)) {
				$clean_mac .= $frag;
			} else if (!in_array($n, self::ASCII_DELIM)) {
				throw new InvalidMacString("$mac invalid char: $frag ($n)");
			}
		}
		if (strlen($clean_mac) != self::MAC_LEN) {
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
