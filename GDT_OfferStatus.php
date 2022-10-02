<?php
namespace GDO\KassiererCard;

use GDO\UI\GDT_Label;
use GDO\User\GDO_User;

final class GDT_OfferStatus extends GDT_Label
{
	public KC_Offer $offer;
	public function offer(KC_Offer $offer) : self
	{
		$this->offer = $offer;
		return $this;
	}
	
	##############
	### Render ###
	##############
	/**
	 * Render offer status.
	 * 3 states:
	 * 1) Date expired
	 * 2) You have all redeems for this offer
	 * 3) You can make use of this coupon.
	 */
	public function renderHTML() : string
	{
		# Expired
		$offer = $this->offer;
		if (!$offer->isOfferValid())
		{
			return t('err_kk_offer_timeout', $offer->renderValidDate());
		}

		# Redeemed
		$user = GDO_User::current();
		$numAvail = $offer->queryNumAvailable($user);
		$numRedeem = $offer->queryNumRedeemed($user);
		$numTotal = $offer->getTotalOffers();
		if ($numAvail <= 0)
		{
			return t('err_kk_offer_no_more_for_you', [
				$numRedeem, $numTotal, $numAvail,
			]);
		}
		
		# Available
		$cost = $offer->getRequiredStars();
		$numRedeem = $offer->queryNumRedeemedTotal();
		return t('kk_offer_status', [$numRedeem, $numTotal, $numAvail, $offer->renderValidDate(), $cost]);
	}
	
}
