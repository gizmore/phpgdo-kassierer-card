<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_String;

final class KC_Slogan extends GDO
{

	public static function randomSloganText(): string
	{
		return self::randomSlogan()->renderSlogan();
	}

	public function renderSlogan(): string
	{
		return html($this->getText());
	}

	public function getText(): string
	{
		return $this->gdoVar('s_text');
	}

	##############
	### Static ###
	##############

	public static function randomSlogan(): self
	{
		return self::table()->select()->order('rand()')->first()->exec()->fetchObject();
	}

	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('s_id'),
			GDT_String::make('s_text')->unique()->notNull(),
		];
	}

}
