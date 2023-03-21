<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_UInt;
use GDO\User\GDO_User;
use GDO\User\GDT_User;

/**
 * A star or diamond has been earned/given.
 * Entries are for competitions.
 *
 * @author gizmore
 */
final class KC_Competition extends GDO
{

	public static function onEarned(GDO_User $user, int $stars, int $diamonds = 0)
	{
		self::blank([
			'c_user' => $user->getID(),
			'c_stars_earned' => $stars,
			'c_diamonds_earned' => $diamonds,
		])->insert();
	}

	##############
	### Static ###
	##############

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
