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
			GDT_CouponToken::make('coup_token')->primary(),
			GDT_Offer::make('coup_offer')->notNull(),
			GDT_CouponStars::make('coup_stars'),
			GDT_CreatedBy::make('coup_creator'),
			GDT_CreatedAt::make('coup_created'),
			GDT_Timestamp::make('coup_redeemed'),
			GDT_User::make('coup_redeemer'),
			GDT_Index::make('index_offers')->indexColumns('coup_offer'),
		];
	}
	
	public function getOffer() : KC_Offer
	{
		return $this->gdoValue('coup_offer');
	}
	
	public function getToken() : string
	{
		return $this->gdoVar('coup_token');
	}
	
	public function isEntered() : bool
	{
		return $this->gdoVar('coup_granted') !== null;
	}
	
	public function renderList() : string
	{
		return GDT_Template::php('KassiererCard', 'coupon_list.php', ['gdo' => $this]);
	}
	
	public static function numStarsCreated(GDO_User $user, int $periodStart) : int
	{
		$periodEnd = $periodStart + Time::ONE_DAY * 2;
		$periodEnd = Time::getDate($periodEnd);
		$periodStart = Time::getDate($periodStart);
		$query = self::table()->select('SUM(coup_stars)')
			->where("coup_created >= '$periodStart' AND coup_created < '$periodEnd'");
		$query->where("coup_creator={$user->getID()}");
		return (int) $query->exec()->fetchValue();
	}
	
// 	public static function numStarsGranted(GDO_User $user, int $periodStart) : int
// 	{
// 		$periodEnd = $periodStart + Time::ONE_DAY * 2;
// 		$periodEnd = Time::getDate($periodEnd);
// 		$periodStart = Time::getDate($periodStart);
// 		$query = self::table()->select('SUM(coup_stars)')
// 			->where("coup_granted >= '$periodStart' AND coup_granted < '$periodEnd'");
// 		$query->where("coup_grantor={$user->getID()}");
// 		return (int) $query->exec()->fetchValue();
// 	}
	
}
