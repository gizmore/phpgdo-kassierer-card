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
			GDT_Token::make('sc_token')->initialNull()->notNull(),
		];
	}

	public static function validateCode($token) : bool
	{
		return !!self::table()->getBy('sc_token', $token);
	}
	
	public static function clearCode($token) : bool
	{
		return self::table()->deleteWhere('sc_token='.quote($token)) === 1;
	}
		
}
