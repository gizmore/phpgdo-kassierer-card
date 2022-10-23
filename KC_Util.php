<?php
namespace GDO\KassiererCard;

use GDO\Date\Time;
use GDO\User\GDO_User;
use GDO\Core\GDO;

/**
 * Various KC utility.
 * 
 * @author gizmore
 *
 */
final class KC_Util
{

	public static function getPeriodStart(int $time) : int
	{
		$start = strtotime('next monday', $time);
		$start -= Time::ONE_WEEK;
		while ($start < $time)
		{
			$start += Time::ONE_DAY;
		}
		return $start - Time::ONE_DAY;
	}
	
	public static function getPeriodStartDate(int $time) : string
	{
		$t = self::getPeriodStart($time);
		return Time::getDate($t);
	}
	
	public static function getPeriodEnd(int $time) : int
	{
		return self::getPeriodStart($time) + Time::ONE_DAY;
	}
	
	public static function getPeriodEndDate(int $time) : string
	{
		$t = self::getPeriodEnd($time);
		return Time::getDate($t);
	}
	
	public static function numStarsCreatedInPeriod(GDO_User $user, int $time) : int
	{
		return KC_Coupon::numStarsCreated($user, self::getPeriodStart($time));
	}
	
	public static function canStarsCreatedInPeriod(GDO_User $user, int $time) : int
	{
		$max = self::maxStarsCreatedInPeriod($user, $time);
		$num = self::numStarsCreatedInPeriod($user, $time);
		return $max - $num;
	}
	
	public static function maxStarsCreatedInPeriod(GDO_User $user, int $time) : int
	{
		if ($user->hasPermission('staff'))
		{
			return 1000;
		}
		elseif ($user->hasPermission('kk_manager'))
		{
			return 100;
		}
		else
		{
			$mod = Module_KassiererCard::instance();
			$free = $mod->cfgFreeStarsPerDay();
			return $free + KC_Util::numStarsAvailable($user);
		}
	}
	
	public static function getStars(GDO_User $user) : int
	{
		return
			self::numStarsCreated($user) +
			self::numStarsEntered($user);
			
	}
	
	public static function numOffersRedeemed(GDO_User $user) : int
	{
		return $user->settingVar('KassiererCard', 'offers_redeemed');
	}
	
	public static function numStarsEntered(GDO_User $user) : int
	{
		return $user->settingVar('KassiererCard', 'stars_entered');
	}
	
	public static function numCouponsEntered(GDO_User $user) : int
	{
		return $user->settingVar('KassiererCard', 'coupons_entered');
	}
	
	public static function numCouponsCreated(GDO_User $user) : int
	{
		return KC_Coupon::table()->numCouponsCreated($user);
	}
	
	public static function numStarsCreated(GDO_User $user) : int
	{
		return KC_Coupon::table()->numCouponsCreated($user);
	}
	
	public static function numStarsAvailable(GDO_User $user) : int
	{
		return $user->settingVar('KassiererCard', 'stars_available');
	}
	
	/**
	 * Check how many offers are available for a user.
	 */
	public static function numOffersAvailable(GDO_User $user) : int
	{
		$query = KC_Offer::getAvailableOffersQuery($user);
		return 2;
	}
	
	public static function numCustomerCouponsForStars(int $stars) : int
	{
		$coupMod = Module_KassiererCard::instance()->cfgCustomerCouponModulus();
		return floor($stars / $coupMod);
	}
	
	public static function canAfford(GDO_User $user, KC_Offer $offer, ?string &$reason=null)
	{
		$gdt = GDT_Offer::make()->affordable()->user($user)->value($offer);
		if (!$gdt->validate($offer))
		{
			$reason = $gdt->renderError();
			return false;
		}
		return true;
	}

	### Hash 
	public static function hashcodeForRedeem(GDO_User $user, KC_Offer $offer) : string
	{
		$data = [
			'user' => $user->getID(),
			'offer' => $offer->getID(),
		];
		return GDO::gdoHashcodeS($data);
	}
	
	############
	### Euro ###
	############
	public static function euroToStars(float $euro) : int
	{
		$starsPerEuro = Module_KassiererCard::instance()->cfgStarsPerEuro();
		return ceil($euro * $starsPerEuro);
	}
	
	public static function starsToEuro(float $stars) : float
	{
		$starsPerEuro = Module_KassiererCard::instance()->cfgStarsPerEuro();
		return round($stars / $starsPerEuro, 2);
	}

	################
	### Diamonds ###
	################
	public static function numDiamondsTotal(GDO_User $user): int
	{
		return $user->settingVar('KassiererCard', 'diamonds_earned');
	}
	
}
