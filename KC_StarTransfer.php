<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\User\GDO_User;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_UInt;
use GDO\User\GDT_User;
use GDO\Date\Time;
use GDO\Core\Application;

/**
 * Star transactions.
 * 
 * If sender is null, it is a free creation.
 * 
 * @author gizmore
 *
 */
final class KC_StarTransfer extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('st_id'),
			GDT_StarTransferType::make('st_type')->notNull(),
			GDT_User::make('st_sender'),
			GDT_User::make('st_target')->notNull(),
			GDT_UInt::make('st_stars')->notNull()->initial('0')->bytes(2),
			GDT_UInt::make('st_diamonds')->notNull()->initial('0')->bytes(2),
			GDT_CreatedAt::make('st_created'),
			GDT_CreatedBy::make('st_creator'),
		];
	}
	
	##############
	### Static ###
	##############
	private static function freeTempKey(int $time)
	{
		$start = KC_Util::getPeriodStart($time);
		$date = Time::getDateWithoutTime($start);
		return "kk_free_{$date}";
	}
	
	public static function gotFreeStars(GDO_User $user, int $time): bool
	{
		$key = self::freeTempKey($time);
		if ($user->tempHas($key))
		{
			return $user->tempGet($key);
		}
		$begin = KC_Util::getPeriodStartDate($time);
		$end = KC_Util::getPeriodEndDate($time);
		$has = !!self::table()->getWhere("st_target={$user->getID()} AND st_created BETWEEN '$begin' AND '$end' AND st_type='kk_free'");
		$user->tempSet($key, $has);
		return $has;
	}
	
	
	public static function freeStars(GDO_User $user, int $stars): self
	{
		$kk = 'KassiererCard';
		$user->increaseSetting($kk, 'stars_available', $stars);
		$user->increaseSetting($kk, 'stars_created', $stars);
		$user->increaseSetting($kk, 'stars_earned', $stars);
		$user->tempSet(self::freeTempKey(Application::$TIME), true);
		return self::blank([
			'st_sender' => null,
			'st_type' => GDT_StarTransferType::FREE,
			'st_target' => $user->getID(),
			'st_stars' => $stars,
		])->insert();
	}
	
	public static function pollDiamonds(GDO_User $user, int $diamonds): self
	{
		$kk = 'KassiererCard';
		$user->increaseSetting($kk, 'diamonds_earned', $diamonds);
		$user->increaseSetting($kk, 'diamonds_available', $diamonds);
		return self::blank([
			'st_sender' => null,
			'st_type' => GDT_StarTransferType::POLL_VOTE,
			'st_target' => $user->getID(),
			'st_diamonds' => $diamonds,
		])->insert();
	}
	
	
	public static function transfer(GDO_User $user, GDO_User $to, int $stars)
	{
		
	}
	
}
