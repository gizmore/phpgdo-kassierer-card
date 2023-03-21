<?php
namespace GDO\KassiererCard;

use DateTime;
use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_String;
use GDO\Core\GDT_UInt;
use GDO\Date\GDT_Date;
use GDO\Date\Time;
use GDO\DB\Query;
use GDO\File\GDO_File;
use GDO\File\GDT_ImageFile;
use GDO\Net\GDT_Url;
use GDO\Payment\GDT_Money;
use GDO\Table\GDT_ListItem;
use GDO\UI\GDT_Button;
use GDO\UI\GDT_Card;
use GDO\UI\GDT_Container;
use GDO\UI\GDT_Message;
use GDO\UI\GDT_Title;
use GDO\User\GDO_User;

/**
 * An offer for a cashier.
 * They are limited to a coupon amount.
 * They have an expiration date.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class KC_Offer extends GDO
{

	public static function getAvailableOffers(GDO_User $user = null): int
	{
		return self::getAvailableOffersQuery($user)
			->selectOnly('COUNT(*)')
			->exec()->fetchValue();
	}

	public static function getAvailableOffersQuery(GDO_User $user = null): Query
	{
		$now = Time::getDateWithoutTime();
		$query = self::table()->select()
			->where('( SELECT IFNULL(COUNT(*), 0) FROM kc_offerredeemed or2 WHERE or2.or_offer=kc_offer.o_id ) < kc_offer.o_total_amt ')
			->where("o_partnership='kk_partner_active'")
			->where("o_expires>'$now'");
		if ($user)
		{
			$starsAvailable = KC_Util::numStarsAvailable($user);
			$query->where("o_required_stars <= $starsAvailable");
		}
		return $query;
	}

	##############
	### Getter ###
	##############

	public function isTestable(): bool
	{
		return false;
	}

	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('o_id'),
			GDT_Partner::make('o_partner')->notNull()->label('partner'),
			GDT_Partnership::make('o_partnership')->notNull(),
			GDT_String::make('o_passphrase')->notNull()->label('passphrase'),
			GDT_Title::make('o_title')->notNull(),
			GDT_Message::make('o_text')->notNull()->label('description'),
			GDT_UInt::make('o_required_stars')->notNull()->bytes(1)->min(1)->initial('1')->label('required_amt'),
			GDT_UInt::make('o_cashier_amt')->notNull()->bytes(1)->min(1)->initial('1')->label('cashier_amt'),
			GDT_UInt::make('o_total_amt')->notNull()->min(1)->label('total_amt'),
			GDT_Date::make('o_expires')->notNull()->minNow()->initial($this->nextFriday())->label('valid_until'),
			GDT_ImageFile::make('o_image')->
			scaledVersion('card', 1050, 600),
			GDT_Money::make('o_invested')->notNull(), # for euros_invested
			GDT_Money::make('o_worth')->notNull(), # for euros_generated
			GDT_CreatedAt::make('o_created'),
			GDT_CreatedBy::make('o_creator'),
		];
	}

	/**
	 * Get the date for next friday.
	 */
	private function nextFriday(): string
	{
		return Time::getDateWithoutTime(strtotime('next friday'));
	}

	public function gdoAfterCreate(GDO $gdo): void
	{
		/** @var $gdo KC_Offer * */
		# Creator Stats
		$kkn = 'KassiererCard';
		$creator = $gdo->getCreator();
		$creator->increaseSetting($kkn, 'offers_created');
		$creator->increaseSetting($kkn, 'euros_invested', $gdo->getInvested());

		# Stats
		$kk = Module_KassiererCard::instance();
		$kk->increaseConfigVar('offers_created');
		$kk->increaseConfigVar('euros_invested', $this->getInvested());
	}

	public function getCreator(): GDO_User { return $this->gdoValue('o_creator'); }

	public function getInvested(): float { return $this->gdoVar('o_invested'); }

	public function renderList(): string
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

		if (!$this->isActive())
		{
			$li->addClass('kk-not-active');
		}

		return $li->render();
	}

	public function getPartner(): KC_Partner { return $this->gdoValue('o_partner'); }

	public function getTitle(): string { return $this->gdoVar('o_title'); }

	public function isActive(): bool { return $this->gdoVar('o_partnership') === GDT_Partnership::ACTIVE; }

	public function renderOption(): string
	{
		return sprintf('<span style="color:red;">%s(%s✯)</span>',
			$this->renderName(), $this->getRequiredStars());
	}

	public function renderName(): string
	{
		return sprintf('#%s-%s',
			$this->getID(), $this->renderTitle());
	}

	#############
	### Hooks ###
	#############

	public function renderTitle(): string
	{
		return $this->gdoDisplay('o_title');
	}

	/**
	 * How many coupons make one offer item?
	 */
	public function getRequiredStars(): int { return $this->gdoValue('o_required_stars'); }

	############
	### HREF ###
	############

	public function renderCard(): string
	{
		return $this->getCard()->render();
	}

	public function getCard(): GDT_Card
	{
		$user = GDO_User::current();
		$card = GDT_Card::make("offer-{$this->getID()}")->gdo($this);
		$card->creatorHeader();
		$card->titleRaw($this->getTitle());
		$card->addField($this->gdoColumnCopy('o_text')->labelNone()->iconNone());
		$iscashier = $user->hasPermission('kk_cashier');
		$iscompany = $user->hasPermission('kk_company');
		$iscustomer = $user->hasPermission('kk_customer');
		$canCreate = $iscompany || $iscustomer;
		$canRedeem = $iscashier;
		$card->actions()->addFields(
			GDT_Button::make('create_coupon')
				->tooltip('tt_create_offer')
				->icon('bee')
				->href(href('KassiererCard', 'CreateCoupon', "&kc_offer={$this->getID()}"))
				->enabled($canCreate));

		$card->actions()->addFields(
			GDT_Button::make('redeem_offer')
				->tooltip('tt_redeem_offer')
				->icon('star')
				->href(href('KassiererCard', 'RedeemOffer', "&id={$this->getID()}"))
				->enabled($canRedeem));

		$card->footer(GDT_OfferStatus::make()->offer($this));

		if (!$this->isActive())
		{
			$card->addClass('kk-not-active');
		}
		return $card;
	}

	###############
	### Private ###
	###############

	public function getPassphrase(): string { return $this->gdoVar('o_passphrase'); }

	#############
	### Avail ###
	#############

	public function getBacksideImage(): ?GDO_File { return $this->gdoValue('o_image'); }

	public function getWorth(): float { return $this->gdoValue('o_worth'); }

	public function isOfferValid(): bool
	{
		$until = $this->gdoValue('o_expires');
		$now = DateTime::createFromFormat('U', strtotime('today'));
		return $until >= $now;
	}

	public function onRedeem(GDO_User $user): void
	{
		KC_OfferRedeemed::onRedeemed($user, $this);
	}

	public function urlRedeem(GDO_User $user): string
	{
		return GDT_Url::absolute($this->hrefRedeem($user));
	}

	public function hrefRedeem(GDO_User $user): string
	{
		$append = "&offer={$this->getID()}";
		$append .= "&user={$user->getID()}";
		$hashcode = KC_Util::hashcodeForRedeem($user, $this);
		$append .= "&token={$hashcode}";
		return href('KassiererCard', 'PartnerRedeemQRCode', $append);
	}

	##############
	### Render ###
	##############

	public function queryNumAvailable(GDO_User $user): int
	{
		$maximum = min([$this->getMaxOffers($user), $this->queryNumAvailableTotal()]);
		$redeemed = $this->queryNumRedeemedUser($user);
		return $maximum - $redeemed;
	}

	/**
	 * How many items/offers can a single user get from this offer.
	 */
	public function getMaxOffers(GDO_User $user): int { return $this->gdoValue('o_cashier_amt'); }

	public function queryNumAvailableTotal(): int
	{
		$maximum = $this->getTotalOffers();
		$redeemed = $this->queryNumRedeemedTotal($this);
		return $maximum - $redeemed;
	}

	/**
	 * How many total offer items are available.
	 */
	public function getTotalOffers(): int { return $this->gdoVar('o_total_amt'); }

	public function queryNumRedeemedTotal(): int
	{
		return KC_OfferRedeemed::table()->countWhere("or_offer={$this->getID()}");
	}

	public function queryNumRedeemedUser(GDO_User $user): int
	{
		return KC_OfferRedeemed::table()->countWhere("or_offer={$this->getID()} AND or_user={$user->getID()}");
	}

	public function queryNumOffers(KC_Partner $partner): int
	{
		return self::countWhere("o_partner={$partner->getID()}");
	}

	##############
	### Static ###
	##############

	public function canAfford(GDO_User $user)
	{
		return KC_Util::canAfford($user, $this);
	}

	### User Avail

	public function renderValidDate(): string
	{
		$validTo = $this->gdoValue('o_expires');
		return Time::displayDateTime($validTo, 'day');
	}

}
