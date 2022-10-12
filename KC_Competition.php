<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\User\GDT_User;
use GDO\Core\GDT_UInt;
use GDO\Core\GDT_CreatedAt;

/**
 * A star or diamond has been earned/given.
 * Entries are for competitions.
 * 
 * @author gizmore
 */
final class KC_Competition extends GDO
{
	
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('c_id'),
			GDT_User::make('c_user'),
			GDT_UInt::make('c_stars_earned')->bytes(2),
			GDT_UInt::make('c_diamonds_earned')->bytes(1),
			GDT_CreatedAt::make('c_created'),
		];
	}


	
}
