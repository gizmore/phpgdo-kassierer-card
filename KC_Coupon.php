<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_Template;
use GDO\User\GDO_User;
use GDO\Date\Time;
use GDO\Core\GDT_Index;
use GDO\Date\GDT_Timestamp;
use GDO\User\GDT_User;

/**
 * A printed coupon to give to an employee.
 * 
 * @author gizmore
 * @version 7.0.1
 */
class KC_Coupon extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_CouponToken::make('kc_token')->primary(),
			GDT_Offer::make('kc_offer')->notNull()->emptyLabel('sel_coupon_offer'),
			GDT_CouponStars::make('kc_stars'),
			GDT_CreatedBy::make('kc_creator'),
			GDT_CreatedAt::make('kc_created'),
			GDT_Timestamp::make('kc_redeemed'),
			GDT_User::make('kc_redeemer'),
			GDT_Index::make('index_offers')->indexColumns('kc_offer'),
		];
	}
	
	public function getOffer() : KC_Offer
	{
		return $this->gdoValue('kc_offer');
	}
	
	public function getToken() : string
	{
		return $this->gdoVar('kc_token');
	}
	
	public function isEntered() : bool
	{
		return $this->gdoVar('kc_granted') !== null;
	}
	
	public function renderList() : string
	{
		return GDT_Template::php('KassiererCard', 'coupon_list.php', ['gdo' => $this]);
	}
	
	public static function numCouponsCreated(GDO_User $user) : int
	{
		return self::table()->countWhere("kc_creator={$user->getID()}");
	}
	
	public static function numStarsCreated(GDO_User $user, int $periodStart) : int
	{
		$periodEnd = $periodStart + Time::ONE_DAY * 2;
		$periodEnd = Time::getDate($periodEnd);
		$periodStart = Time::getDate($periodStart);
		$query = self::table()->select('SUM(kc_stars)')
			->where("kc_created >= '$periodStart' AND kc_created < '$periodEnd'");
		$query->where("kc_creator={$user->getID()}");
		return (int) $query->exec()->fetchValue();
	}
	
// 	public static function numStarsGranted(GDO_User $user, int $periodStart) : int
// 	{
// 		$periodEnd = $periodStart + Time::ONE_DAY * 2;
// 		$periodEnd = Time::getDate($periodEnd);
// 		$periodStart = Time::getDate($periodStart);
// 		$query = self::table()->select('SUM(kc_stars)')
// 			->where("kc_granted >= '$periodStart' AND kc_granted < '$periodEnd'");
// 		$query->where("kc_grantor={$user->getID()}");
// 		return (int) $query->exec()->fetchValue();
// 	}
	
}
