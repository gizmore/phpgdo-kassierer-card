<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Char;
use GDO\Util\Random;

final class GDT_CouponToken extends GDT_Char
{
	const LENGTH = 10;
	const CHARSET = '2345679ACDEFGHKMNPQRSTUVWXY';
	
	protected function __construct()
	{
		parent::__construct();
		$this->length(self::LENGTH);
		$this->ascii()->caseI();
		$this->pattern('/['.self::CHARSET.']{'.self::LENGTH.'}/iD');
	}
	
	public function blankData() : array
	{
		return [$this->getName() => self::generateRandomKey()];
	}
	
	public static function generateRandomKey()
	{
		do
		{
			$key = '';
			for ($i = 0; $i < self::LENGTH; $i++)
			{
				$key .= Random::randomKey(1, self::CHARSET);
			}
		}
		while (self::keyExists($key));
		return $key;
	}
	
	private static function keyExists(string $key) : bool
	{
		return !!KC_Coupon::getBy('kc_token', $key);
	}
	
	##############
	### Render ###
	##############
	public function displayVar(string $var=null) : string
	{
		$chunks = str_split($this->getVar(), 2);
		return implode('-', $chunks);
	}
	
}
