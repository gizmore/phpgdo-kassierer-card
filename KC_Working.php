<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\User\GDO_User;
use GDO\User\GDT_User;
use GDO\Core\GDT_Object;
use GDO\Core\GDT_AutoInc;
use GDO\Date\Time;
use GDO\Date\GDT_Timestamp;

/**
 * Relation table. User working at Business.
 * Static API to track working places for users.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class KC_Working extends GDO
{
	public function gdoCached() : bool { return false; }
	
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('work_id'),
			GDT_User::make('work_user')->notNull(),
			GDT_Object::make('work_business')->table(KC_Business::table())->notNull(),
			GDT_Timestamp::make('work_from')->notNull(),
			GDT_Timestamp::make('work_until'),
		];
	}

	##############
	### Static ###
	##############
	public static function startedWorking(GDO_User $user, KC_Business $biz, string $dateFrom=null) : void
	{
		$dateFrom = $dateFrom ? $dateFrom : Time::getDate();
		self::blank([
			'work_user' => $user->getID(),
			'work_business' => $biz->getID(),
			'work_from' => $dateFrom,
		])->insert();
	}
	
	public static function getActiveForUser(GDO_User $user) : ?self
	{
		return self::table()->select()->
			where("work_user={$user->getID()} AND work_until IS NULL")->
			first()->exec()->fetchObject();
	}
	
	public static function stoppedWorking(GDO_User $user) : void
	{
		if ($row = self::getActiveForUser($user))
		{
			$row->saveVar('work_until', Time::getDate());
		}
	}
	
	public static function isWorkingThere(GDO_User $user, KC_Business $business) : bool
	{
		$today = Time::getDate();
		return self::table()->select('1')->
			where("work_user={$user->getID()} AND work_business={$business->getID()}")->
			where("work_from < '$today'")->
			where("work_until > '$today'")->
			exec()->fetchValue() === '1';
	}
	
}
