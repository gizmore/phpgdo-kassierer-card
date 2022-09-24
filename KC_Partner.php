<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Address\GDT_Address;
use GDO\Category\GDT_Category;

final class KC_Partner extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('p_id'),
			GDT_Category::make('p_category'),
			GDT_Address::make('p_address'),
		];
	}
	
}
