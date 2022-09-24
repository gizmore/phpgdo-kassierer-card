<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\User\GDO_User;
use GDO\Date\GDT_Timestamp;

/**
 * An entered coupon.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class KC_CouponEntered extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('ce_id'),
			GDT_Offer::make('ce_offer')->notNull(),
			GDT_CreatedAt::make('ce_created'),
			GDT_CreatedBy::make('ce_creator'),
			GDT_Timestamp::make('ce_redeemed'),
		];
	}
	
// 	public  function getOffer() : KC_Offer
// 	{
// 		return $this->gdoValue('ce_offer');
// 	}
	
	##############
	### Static ###
	##############
	public static function queryNumRedeemedTotal(KC_Offer $offer) : int
	{
		$condition = "ce_offer={$offer->getID()} AND ce_redeemed IS NOT NULL";
		$total = self::table()->countWhere($condition);
		return floor($total / $offer->getRequiredCoupons());
	}
	
	/**
	 * Query the number of entered coupons, ready for redemption.
	 */
	public static function queryNumCoupons(GDO_User $user, KC_Offer $offer) : int
	{
		$condition = "ce_creator={$user->getID()} AND ce_offer={$offer->getID()} AND ce_redeemed IS NULL";
		return self::table()->countWhere($condition);
	}
	
	/**
	 * Query the number of redeemed coupon offers.
	 */
	public static function queryNumRedeemed(GDO_User $user, KC_Offer $offer) : int
	{
		$condition = "ce_creator={$user->getID()} AND ce_offer={$offer->getID()} AND ce_redeemed IS NOT NULL";
		$total = self::table()->countWhere($condition);
		return floor($total / $offer->getRequiredCoupons());
	}

}
