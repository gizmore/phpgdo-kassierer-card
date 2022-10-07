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
use GDO\DB\Query;
use GDO\Payment\GDT_Money;

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
			GDT_UInt::make('o_required_stars')->notNull()->bytes(1)->min(1)->initial('1')->label('required_amt'),
			GDT_UInt::make('o_cashier_amt')->notNull()->bytes(1)->min(1)->initial('1')->label('cashier_amt'),
			GDT_UInt::make('o_total_amt')->notNull()->min(1)->label('total_amt'),
			GDT_Date::make('o_expires')->notNull()->minNow()->initial($this->nextFriday())->label('valid_until'),
			GDT_ImageFile::make('o_image')->exactSize(1050, 600),
			GDT_Money::make('o_invested')->notNull(), # for euros_invested
			GDT_Money::make('o_worth')->notNull(), # for euros_generated
// 			GDT_Virtual::make('o_total_redeemed')->gdtType(GDT_UInt::make())->subquery("SELECT COUNT(*) FROM kc_offerredeemed or2 WHERE or2.or_offer=kc_offer.o_id"),
			GDT_CreatedAt::make('o_created'),
			GDT_CreatedBy::make('o_creator'),
		];
	}

	##############
	### Getter ###
	##############
	
	public function getTitle() : string { return $this->gdoVar('o_title'); }
	
	public function getPartner() : KC_Partner { return $this->gdoValue('o_partner'); }
	
	public function getCreator() : GDO_User { return $this->gdoValue('o_creator'); }
	
	public function getBacksideImage() : ?GDO_File { return $this->gdoValue('o_image'); }
	
	/**
	 * How many coupons make one offer item?
	 */
	public function getRequiredStars() : int { return $this->gdoValue('o_required_stars'); }
	
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
	public function getTotalOffers() : int { return $this->gdoVar('o_total_amt'); }
	
	public function getWorth() : float { return $this->gdoValue('o_worth'); }
	
	public function getInvested() : float { return $this->gdoVar('o_invested'); }
	
	public function isOfferValid() : bool
	{
		$until = $this->gdoValue('o_expires');
		$now = \DateTime::createFromFormat('U', strtotime('today'));
		return $until >= $now;
	}
	
	#############
	### Hooks ###
	#############
	public function gdoAfterCreate(GDO $gdo) : void
	{
		/** @var $gdo KC_Offer **/
		# Creator Stats
		$kkn = 'KassiererCard';
		$creator = $gdo->getCreator();
		$creator->increaseSetting($kkn, 'offers_created');
// 		$creator->increaseSetting($kkn, 'stars_created');
		$creator->increaseSetting($kkn, 'euros_invested', $gdo->getInvested());
		
		# Stats
		$kk = Module_KassiererCard::instance();
		$kk->increaseConfigVar('offers_created');
// 		$kk->increaseConfigVar('stars_created');
		$kk->increaseConfigVar('euros_invested', $this->getInvested());
	}
	
	############
	### HREF ###
	############
	public function hrefPartnerRedeemQRCode(GDO_User $user) : string
	{
		$append = "&offer={$this->getID()}";
		$append .= "&user={$user->getID()}";
		$hashcode = KC_Util::hashcodeForRedeem($user, $this);
		$append .= "&hashcode={$hashcode}";
		return href('KassiererCard', 'PartnerRedeemQRCode', $append);
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
		$maximum = min([$this->getMaxOffers($user), $this->queryNumAvailableTotal()]);
		$redeemed = $this->queryNumRedeemedUser($user);
		return $maximum - $redeemed;
	}
	
	public function queryNumAvailableTotal() : int
	{
		$maximum = $this->getTotalOffers();
		$redeemed = $this->queryNumRedeemedTotal($this);
		return $maximum - $redeemed;
	}
	
	public function queryNumRedeemedUser(GDO_User $user) : int
	{
		return KC_OfferRedeemed::table()->countWhere("or_offer={$this->getID()} AND or_user={$user->getID()}");
	}
	
	public function queryNumRedeemedTotal() : int
	{
		return KC_OfferRedeemed::table()->countWhere("or_offer={$this->getID()}");
	}
	
	public function queryNumOffers(KC_Partner $partner) : int
	{
		return self::countWhere("o_partner={$partner->getID()}");
	}
	
	public function canAfford(GDO_User $user)
	{
		return KC_Util::canAfford($user, $this);
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
		$user = GDO_User::current();
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
		
		$iscashier = $user->hasPermission('kk_cashier');
		$iscompany = $user->hasPermission('kk_company');
		$iscustomer = $user->hasPermission('kk_customer');
		$canCreate = $iscompany || $iscustomer;
		$canRedeem = $iscashier;
		
		$li->actions()->addFields(
			GDT_Button::make('create_coupon')
			->tooltip('tt_create_offer')
			->icon('bee')
			->href(href('KassiererCard', 'CreateCoupon', "&kc_offer={$this->getID()}"))
			->enabled($canCreate));
		
		$li->actions()->addFields(
			GDT_Button::make('redeem_offer')
			->tooltip('tt_redeem_offer')
			->icon('star')
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
	
	##############
	### Static ###
	##############
	public static function getAvailableOffers(GDO_User $user=null): int
	{
		return self::getAvailableOffersQuery($user)
			->selectOnly('COUNT(*)')
			->exec()->fetchValue();
	}
	
	### User Avail
	public static function getAvailableOffersQuery(GDO_User $user=null) : Query
	{
		$now = Time::getDateWithoutTime();
		$query = self::table()->select()
				->where("( SELECT IFNULL(COUNT(*), 0) FROM kc_offerredeemed or2 WHERE or2.or_offer=kc_offer.o_id ) < kc_offer.o_total_amt ")
				->where("o_expires>'$now'");
		if ($user)
		{
			$starsAvailable = KC_Util::numStarsAvailable($user);
			$query->where("o_required_stars <= $starsAvailable");
		}
		return $query;
	}
	
}
