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
use GDO\UI\GDT_Title;
use GDO\UI\GDT_Button;
use GDO\UI\GDT_Container;
use GDO\File\GDT_ImageFile;
use GDO\File\GDO_File;

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
			GDT_Title::make('o_title')->notNull(),
			GDT_Message::make('o_text')->notNull()->label('description'),
			GDT_UInt::make('o_required_amt')->notNull()->bytes(1)->min(1)->initial('1')->label('required_amt'),
			GDT_UInt::make('o_cashier_amt')->notNull()->bytes(1)->min(1)->initial('1')->label('cashier_amt'),
			GDT_UInt::make('o_total_amt')->notNull()->min(1)->label('total_amt'),
			GDT_Date::make('o_expires')->notNull()->minNow()->initial($this->nextFriday())->label('valid_until'),
			GDT_ImageFile::make('o_image')->exactSize(1050, 600),
			GDT_CreatedAt::make('o_created'),
			GDT_CreatedBy::make('o_creator'),
		];
	}

	##############
	### Getter ###
	##############
	
	public function getTitle() : string { return $this->gdoVar('o_title'); }
	
	public function getPartner() : KC_Partner { return $this->gdoValue('o_partner'); }

	public function getBacksideImage() : ?GDO_File { return $this->gdoValue('o_image'); }
	
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
		$until = $this->gdoValue('o_expires');
		$now = \DateTime::createFromFormat('U', strtotime('today'));
		return $until >= $now;
	}
	
	###############
	### Private ###
	###############
	/**
	 * Get the date for next friday.
	 */
	private function nextFriday() : string
	{
		return Time::getDateWithoutTime(strtotime('next friday'));
	}
	
	#############
	### Avail ###
	#############
	public function queryNumAvailable(GDO_User $user) : int
	{
		$redeemed = KC_CouponRedeemed::queryNumRedeemed($user, $this);
		$maximum = $this->getMaxOffers($user);
		return $maximum - $redeemed;
	}
	
	public function queryNumAvailableTotal() : int
	{
		$maximum = $this->getTotalOffers();
		$redeemed = KC_CouponRedeemed::queryNumRedeemedTotal($this);
		return $maximum - $redeemed;
	}
	
	public function queryNumRedeemed(GDO_User $user) : int
	{
		return KC_CouponRedeemed::queryNumRedeemed($user, $this);
	}
	
	public function queryNumRedeemedTotal() : int
	{
		return KC_CouponRedeemed::queryNumRedeemedTotal($this);
	}
	
	public function queryNumOffers(KC_Partner $partner) : int
	{
		return self::countWhere("o_partner={$partner->getID()}");
	}
	
	##############
	### Render ###
	##############
	public function renderValidDate() : string
	{
		$validTo = $this->gdoValue('o_expires');
		return Time::displayDateTime($validTo, 'day');
	}
	
	public function renderList() : string
	{
		$partner = $this->getPartner();
		
		$li = GDT_ListItem::make()->gdo($this);
		$li->creatorHeader();
		$li->titleRaw($this->getTitle());
		$content = GDT_Container::make()->vertical();
		$content->addFields(
			$partner->linkPartner(),
			$this->gdoColumn('o_text'),
		);
		$li->content($content);
		
		$user = GDO_User::current();
		
		$iscashier = $user->hasPermission('kk_cashier');
		$iscompany = $user->hasPermission('kk_company');
		$iscustomer = $user->hasPermission('kk_customer');
		$canCreate = $iscompany || $iscustomer;
		$canRedeem = $iscashier;
		$li->actions()->addFields(
			GDT_Button::make('create_coupon')
			->tooltip('tt_create_offer')
			->href(href('KassiererCard', 'CreateCoupon', "&kc_offer={$this->getID()}"))
			->enabled($canCreate));
		$li->actions()->addFields(
			GDT_Button::make('redeem_offer')
			->tooltip('tt_redeem_offer')
			->href(href('KassiererCard', 'RedeemOffer', "&id={$this->getID()}"))
			->enabled($canRedeem));
		
		$li->footer(GDT_OfferStatus::make()->offer($this));
		
		return $li->render();
	}
	
	public function renderOption() : string
	{
		return '#'.$this->getID().'-'.$this->gdoDisplay('o_title');
	}

	public function renderName() : string
	{
		return $this->renderOption();
	}
}
