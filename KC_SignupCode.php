<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_Token;

final class KC_SignupCode extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('sc_id'),
			GDT_AccountType::make('sc_type')->notNull(),
			GDT_Token::make('sc_token')->initialNull()->notNull()->unique(),
		];
	}

	public static function validateCode(string $token, string $type) : bool
	{
		if (!($code = self::table()->getBy('sc_token', $token)))
		{
			return false;
		}
		if ($code->getType() !== $type)
		{
			return false;
		}
		return true;
	}
	
	public static function clearCode(string $token) : bool
	{
		return self::table()->deleteWhere('sc_token='.quote($token)) === 1;
	}
		
}
