<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\User\GDO_User;
use GDO\User\GDT_User;
use GDO\Core\GDT_CreatedAt;
use GDO\Net\GDT_PackedIP;
use GDO\Core\GDT_AutoInc;

/**
 * A rate limiter for every time you call getByToken().
 * Once per request/process.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 7.0.1
 */
final class KC_TokenRequest extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('tr_id'),
			GDT_PackedIP::make('tr_ip'),
			GDT_User::make('tr_creator'),
			GDT_CreatedAt::make('tr_created'),
		];
	}
	
	##############
	### Static ###
	##############
	public static function afterFailedRequest(GDO_User $user): bool
	{
		return self::blank([
			'tr_ip' => GDT_PackedIP::current(),
			'tr_creator' => $user->getID(),
		])->insert();
	}
	
	public static function isBlocked(GDO_User $user, string &$reason=null)
	{
		return false;
	}
		
		
}
