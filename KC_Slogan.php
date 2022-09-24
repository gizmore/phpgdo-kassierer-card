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
			GDT_String::make('s_text')->notNull(),
		];
	}
	
}
