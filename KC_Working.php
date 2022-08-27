<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\User\GDT_User;
use GDO\Core\GDT_Object;
use GDO\Core\GDT_AutoInc;
use GDO\Date\GDT_DateTime;

/**
 * Relation table. User working at Business.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class KC_Working extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('work_id'),
			GDT_User::make('work_user')->notNull(),
			GDT_Object::make('work_business')->table(KC_Business::table())->notNull(),
			GDT_DateTime::make('work_from')->notNull(),
			GDT_DateTime::make('work_until'),
		];
	}


	
}
