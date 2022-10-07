<?php
namespace GDO\KassiererCard\Method;

use GDO\Cronjob\MethodCronjob;
use GDO\Date\Time;
use GDO\KassiererCard\KC_TokenRequest;
use GDO\Core\Application;
use GDO\KassiererCard\Module_KassiererCard;

/**
 * Clean up old TOKEN REQUESTs.
 * 
 * @author gizmore
 * @since 7.0.1
 */
final class CronjobTokenRequest extends MethodCronjob
{
	public function runAt()
	{
		return $this->runHourly();
	}
	
	public function run()
	{
		if ($deleted = $this->deleteOldRequests())
		{
			$this->logNotice("Deleted {$deleted} old token requests.");
		}
	}
	
	public function deleteOldRequests(): int
	{
		$maxAge = Module_KassiererCard::instance()->cfgTokenRequestTime();
		$cut = Time::getDate(Application::$MICROTIME - $maxAge);
		return KC_TokenRequest::table()->deleteWhere("tr_created < '$cut'");
	}
	
}
