<?php
namespace GDO\KassiererCard;

use GDO\Date\Time;
use GDO\User\GDO_User;
use GDO\Core\Website;

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
			$start += Time::ONE_DAY * 2;
		}
		return $start - Time::ONE_DAY * 2;
	}
	
	public static function getPeriodEnd(int $time) : int
	{
		return self::getPeriodStart($time) + Time::ONE_DAY * 2;
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
		$mod = Module_KassiererCard::instance();
		$min = $mod->cfgFreeStarsPerPeriod();
		return $min;
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
	
	public static function numStarsAvaliable(GDO_User $user) : int
	{
		return $user->settingVar('KassiererCard', 'stars_available');
	}
	
	public static function numCouponsAvailable(GDO_User $user) : int
	{
		$query = KC_Offer::getAvailableOffersQuery($user);
		return 2;
	}
	
	public static function numCustomerCouponsForStars(int $stars) : int
	{
		$coupMod = Module_KassiererCard::instance()->cfgCustomerCouponModulus();
		return floor($stars / $coupMod);
	}
	
	public static function giveStars(GDO_User $user, int $stars) : void
	{
		
		Website::message('KassiererCard.org', 'msg_earned_stars', [$stars]);
	}
	
}
