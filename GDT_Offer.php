<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_ObjectSelect;
use GDO\Date\Time;
use GDO\User\GDO_User;
use GDO\User\WithUser;

/**
 * An offer selection.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_Offer extends GDT_ObjectSelect
{
	use WithUser;
	
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
	
	public bool $fromMe = false;
	public function fromMe(bool $fromMe=true) : self
	{
		$this->fromMe = $fromMe;
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
		if ($this->fromMe)
		{
			$query->joinObject('o_partner');
			$query->where("o_partner_t.user_id={$this->getUser()->getID()}");
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
				# Star count
				$user = GDO_User::current();
				$stars = $value->getRequiredStars();
				$avail = KC_Util::numStarsAvailable($user);
				if ($avail < $stars)
				{
					return $this->error('err_kk_offer_afford', [
						$stars, $avail]);
				}

				# Avail total
				$numRedeem = $value->queryNumRedeemedTotal();
				$numTotal = $value->getTotalOffers();
				if ($numRedeem >= $numTotal)
				{
					return $this->error('err_kk_offer_totaled', [
						$stars, $avail]);
				}
				
				$numAvail = $value->queryNumAvailable($user);
				$numRedeem = $value->queryNumRedeemedUser($user);
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
