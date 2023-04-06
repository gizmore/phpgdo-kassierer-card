<?php
namespace GDO\KassiererCard;

use GDO\Core\Application;
use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Date\Time;
use GDO\Net\GDT_IP;
use GDO\Net\GDT_PackedIP;
use GDO\User\GDO_User;
use GDO\User\GDT_User;

/**
 * A rate limiter for every time you call getByToken().
 * Once per request/process.
 *
 * @version 7.0.1
 * @since 7.0.1
 * @author gizmore
 */
final class KC_TokenRequest extends GDO
{

	public static function afterFailedRequest(GDO_User $user): bool
	{
		return self::blank()->insert();
	}

	##############
	### Static ###
	##############

	public static function isBlocked(GDO_User $user, string &$reason = null): bool
	{
		$kk = Module_KassiererCard::instance();
		if ($maxTries = $kk->cfgTokenRequestAmt())
		{
			$maxTime = $kk->cfgTokenRequestTime();
			$cut = Time::getDate(Application::$MICROTIME - $maxTime);
			$query = self::table()->select('COUNT(*), MIN(tr_created)');
			$query->where("tr_created >= '$cut'");
			if ($user->isUser())
			{
				$query->where("tr_creator='{$user->getID()}'");
			}
			$ip = GDT_IP::current();
			if (GDT_IP::isIPv6($ip))
			{
				$ip = substr($ip, 0, 8);
			}
			$eip = GDT_PackedIP::ip2packed($ip);
			$eip = GDO::escapeSearchS($eip);
			if (GDT_IP::isIPv6($ip))
			{
				$query->orWhere("tr_ip LIKE '{$eip}%'");
			}
			else
			{
				$query->orWhere("tr_ip = '$eip'");
			}
			[$count, $oldest] = $query->exec()->fetchRow();
			if ($count >= $maxTries)
			{
				$wait = $maxTime - Time::getAge($oldest);
				$reason = t('err_kc_token_tries', [
					Time::humanDuration($wait),
				]);
				return true;
			}
		}

		return false;
	}

	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('tr_id'),
			GDT_PackedIP::make('tr_ip')->useCurrent(),
			GDT_CreatedBy::make('tr_creator'),
			GDT_CreatedAt::make('tr_created'),
		];
	}


}
