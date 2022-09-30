<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\User\GDO_User;

final class KC_CouponRedeemed extends GDO
{
	public function gdoColumns() : array
	{
		return [
			GDT_AutoInc::make('cr_id'),
			GDT_Offer::make('cr_offer')->notNull(),
			GDT_CouponStars::make('cr_stars'),
			GDT_CreatedAt::make('cr_created'),
			GDT_CreatedBy::make('cr_creator'),
		];
	}
	
	##############
	### Static ###
	##############
	public static function queryNumRedeemed(GDO_User $user, KC_Offer $offer) : int
	{
		$condition = "cr_creator={$user->getID()} AND cr_offer={$offer->getID()}";
		return self::table()->countWhere($condition);
	}
	
	public static function queryNumRedeemedTotal(KC_Offer $offer) : int
	{
		$condition = "cr_offer={$offer->getID()}";
		return self::table()->countWhere($condition);
	}
	
}
