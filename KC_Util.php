<?php
namespace GDO\KassiererCard;

use GDO\Date\Time;
use GDO\User\GDO_User;

/**
 * Various KC utility.
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
		$min = $mod->cfgFreeStars();
		return $min;
	}
	
	public static function getBees(GDO_User $user) : int
	{
		return (int) $user->settingVar('KassiererCard', 'coupon_help');
	}
	
	public static function getSuns(GDO_User $user) : int
	{
		return (int) $user->settingVar('KassiererCard', 'coupon_kind');
	}
	
	public static function getStars(GDO_User $user) : int
	{
		return (int) $user->settingVar('KassiererCard', 'coupon_fast');
	}
	
	public static function numCouponsCreated($user) : int
	{
		return 0;
	}
	
	public static function numStarsCreated($user) : int
	{
		return 0;
	}
	
}
