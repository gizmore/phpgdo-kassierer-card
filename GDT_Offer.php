<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_ObjectSelect;
use GDO\Date\Time;
use GDO\User\GDO_User;

/**
 * An offer selection.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_Offer extends GDT_ObjectSelect
{
	protected function __construct()
	{
		parent::__construct();
		$this->table(KC_Offer::table());
	}
	
	public bool $expired = false;
	public function expired(bool $expired=true) : self
	{
		$this->expired = $expired;
		return $this;
	}
	
	public bool $affordable = false;
	public function affordable(bool $affordable=true) : self
	{
		$this->affordable = $affordable;
		return $this;
	}
	
	public function getChoices()
	{
		$query = KC_Offer::table()->select();
		if (!$this->expired)
		{
			$now = Time::getDateWithoutTime();
			$query->where("o_expires >= '$now'");
		}
		return $query->exec()->fetchAllArray2dObject();
	}
	
	public function validate($value) : bool
	{
		if (!parent::validate($value))
		{
			return false;
		}
		if ($value)
		{
			/** @var $value KC_Offer **/
			if (!$this->expired)
			{
				if (!$value->isOfferValid())
				{
					return $this->error('err_kk_offer_timeout', [
						$value->renderValidDate()]);
				}
			}
			if ($this->affordable)
			{
				$user = GDO_User::current();
				if (!$value->canAfford($user))
				{
					return $this->error('err_kk_offer_afford', [
						$value->getRequiredStars(), KC_Util::numStarsAvaliable($user)]);
				}
				$numAvail = $value->queryNumAvailable($user);
				$numRedeem = $value->queryNumRedeemed($user);
				$numTotal = $value->getTotalOffers();
				if ($numAvail <= 0)
				{
					return t('err_kk_offer_no_more_for_you', [
						$numRedeem, $numTotal, $numAvail,
					]);
				}
			}
		}
		return true;
	}
	
}
