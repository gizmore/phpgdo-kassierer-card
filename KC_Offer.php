<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_String;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_UInt;
use GDO\Date\GDT_Date;
use GDO\Date\Time;
use GDO\UI\GDT_Message;
use GDO\Table\GDT_ListItem;
use GDO\User\GDO_User;

/**
 * An offer for a cashier.
 * They are limited to a coupon amount.
 * They have an expiration date.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class KC_Offer extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('o_id'),
			GDT_Partner::make('o_partner')->notNull()->label('partner'),
			GDT_String::make('o_passphrase')->notNull()->label('passphrase'),
			GDT_Message::make('o_text')->notNull()->label('description'),
			GDT_UInt::make('o_required_amt')->notNull()->bytes(1)->min(1)->initial('1')->label('required_amt'),
			GDT_UInt::make('o_cashier_amt')->notNull()->bytes(1)->min(1)->initial('1')->label('cashier_amt'),
			GDT_UInt::make('o_total_amt')->notNull()->min(1)->label('total_amt'),
			GDT_Date::make('o_valid_until')->notNull()->minNow()->initial($this->nextFriday())->label('valid_until'),
			GDT_CreatedAt::make('o_created'),
			GDT_CreatedBy::make('o_creator'),
		];
	}

	/**
	 * How many coupons make one offer item?
	 */
	public function getRequiredCoupons() : int { return $this->gdoValue('o_required_amt'); }
	
	/**
	 * How many items/offers can a single user get from this offer.
	 */
	public function getMaxOffers(GDO_User $user) : int { return $this->gdoValue('o_cashier_amt'); }

	/**
	 * How many total coupons are available.
	 */
	public function getTotalCoupons() : int { return $this->gdoValue('o_total_amt'); }

	/**
	 * How many total offer items are available.
	 */
	public function getTotalOffers() : int { return floor($this->getTotalCoupons() / $this->getRequiredCoupons()); }
	
	public function isOfferValid() : bool
	{
		$until = $this->gdoValue('o_valid_until');
		$now = new \DateTime(strtotime('today'));
		return $until >= $now;
	}
	
	###
	
	private function nextFriday() : string
	{
		return Time::getDateWithoutTime(strtotime('next friday'));
	}
	
	#############
	### Avail ###
	#############
	public function queryNumAvailable(GDO_User $user) : int
	{
		$redeemed = KC_CouponEntered::queryNumRedeemed($user, $this);
		$maximum = $this->getMaxOffers($user);
		return $maximum - $redeemed;
	}
	
	public function queryNumAvailableTotal() : int
	{
		$maximum = $this->getTotalOffers();
		$redeemed = KC_CouponEntered::queryNumRedeemedTotal($this);
		return $maximum - $redeemed;
	}
	
	public function queryNumRedeemed(GDO_User $user) : int
	{
		return KC_CouponEntered::queryNumRedeemed($user, $this);
	}
	
	public function queryNumRedeemedTotal() : int
	{
		return KC_CouponEntered::queryNumRedeemedTotal($this);
	}
	
	##############
	### Render ###
	##############
	public function renderValidDate() : string
	{
		$validTo = $this->gdoValue('o_valid_until');
		return Time::displayDateTime($validTo, 'day');
	}
	
	public function renderList() : string
	{
		$li = GDT_ListItem::make();
		$li->creatorHeader();
		$li->content($this->gdoColumn('o_text'));
		$li->footer(GDT_OfferStatus::make()->offer($this));
		return $li->render();
	}
	
	
}
