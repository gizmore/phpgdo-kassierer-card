<?php
namespace GDO\KassiererCard;

use GDO\Util\Random;
use GDO\Core\GDT_Template;
use GDO\Core\GDT_Token;

final class GDT_CouponToken extends GDT_Token
{
	const LENGTH = 10;
// 	const CHARSET = '2345679ACDEFGHKMNPQRSTUVWXYZ';
	const CHARSET = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	
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
	
	public function initialRandomKey() : self
	{
		return $this->initial(self::generateRandomKey());
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
		return !!KC_Coupon::getByToken($key);
	}
	
	public function validate($value): bool
	{
		if (!parent::validate($value))
		{
			return false;
		}
		if ($value)
		{
			if (!self::keyExists($value))
			{
				$this->reset(true);
				return $this->error('err_kk_coupon_used');
			}
		}
		return true;
	}

	##############
	### Render ###
	##############
	public function displayVar(string $var=null) : string
	{
		$chunks = str_split($this->getVar(), 2);
		return implode('-', $chunks);
	}
	
	public function renderForm() : string
	{
		return GDT_Template::php('KassiererCard', 'token_form.php', ['field' => $this]);
	}
	
}
