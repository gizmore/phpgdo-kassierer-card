<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_String;

final class KC_Slogan extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('s_id'),
			GDT_String::make('s_text')->unique()->notNull(),
		];
	}
	
	public function getText() : string
	{
		return $this->gdoVar('s_text');
	}
	
	public function renderSlogan()  : string
	{
		return html($this->getText());
	}
	
	##############
	### Static ###
	##############
	public static function randomSlogan() : self
	{
		return self::table()->select()->order('rand()')->first()->exec()->fetchObject();
	}
	
	public static function randomSloganText() : string
	{
		return self::randomSlogan()->renderSlogan();
	}
}
