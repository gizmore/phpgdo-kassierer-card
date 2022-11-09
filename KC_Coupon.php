<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_Checkbox;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_Template;
use GDO\Core\Website;
use GDO\User\GDO_User;
use GDO\User\GDO_UserPermission;
use GDO\Date\Time;
use GDO\Core\GDT_Index;
use GDO\Date\GDT_Timestamp;
use GDO\User\GDT_User;
use GDO\Mail\Mail;
use GDO\Net\GDT_Url;
use GDO\QRCode\GDT_QRCode;
use GDO\UI\GDT_Image;
use GDO\UI\GDT_SVGImage;
use GDO\Core\GDT_String;

/**
 * A printed coupon to give to an employee.
 * 
 * @author gizmore
 * @version 7.0.1
 */
class KC_Coupon extends GDO
{
	public static $INVITATION_TYPES = ['kk_cashier', 'kk_company', 'kk_customer'];
	
	public function gdoColumns(): array
	{
		return [
			GDT_CouponToken::make('kc_token')->primary(),
			GDT_CouponType::make('kc_type')->notNull(),
			GDT_Checkbox::make('kc_invitation')->notNull()->initial('0'),
			GDT_CouponStars::make('kc_stars')->notNull()->initial('0'),
			GDT_String::make('kc_info'),
			GDT_Offer::make('kc_offer')->emptyLabel('sel_coupon_offer'),
	
			GDT_CreatedBy::make('kc_creator'),
			GDT_CreatedAt::make('kc_created'),
			GDT_Timestamp::make('kc_printed'),
			GDT_User::make('kc_enterer')->label('kc_enterer'),
			GDT_Timestamp::make('kc_entered'),
			
			GDT_Index::make('index_offers')->indexColumns('kc_offer'),
			GDT_Index::make('index_kc_creator')->indexColumns('kc_creator'),
			GDT_Index::make('index_kc_enterer')->indexColumns('kc_enterer'),
		];
	}
	
	public function getCreator() : GDO_User
	{
		return $this->gdoValue('kc_creator');
	}
	
	public function getOffer() : ?KC_Offer
	{
		return $this->gdoValue('kc_offer');
	}
	
	public function getType() : string
	{
		return $this->gdoVar('kc_type');
	}
	
	public function getToken() : string
	{
		return $this->gdoVar('kc_token');
	}
	
	public function isUserInvitation(): bool
	{
		return $this->gdoValue('kc_invitation');
	}
	
	public function getStars() : int
	{
		return $this->gdoVar('kc_stars');
	}
	
	public function isEntered() : bool
	{
		return $this->gdoVar('kc_entered') !== null;
	}
	
	public function getEnterer() : ?GDO_User
	{
		return $this->gdoValue('kc_enterer');
	}
	
	public function getEntered() : ?string
	{
		return $this->gdoVar('kc_entered');
	}
	
	public function getSlogan() : string
	{
		return KC_Slogan::randomSloganText();
	}
	
	public function isPrinted() : bool
	{
		return $this->gdoVar('kc_printed') !== null;
	}

	public function getPrinted() : string
	{
		return $this->gdoVar('kc_printed');
	}
	
	public function isInvitation() : bool
	{
		return in_array($this->getType(), self::$INVITATION_TYPES, true);
	}
	
	public function getOtherUser(GDO_User $user): GDO_User
	{
		$uid = $user->getID();
		if ($uid === $this->gdoVar('kc_creator'))
		{
			return $this->gdoValue('kc_enterer');
		}
		return $this->gdoValue('kc_creator');
	}
	
	#############
	### Hooks ###
	#############
	public function gdoAfterCreate(GDO $gdo) : void
	{
		/** @var $gdo KC_Coupon **/
		
		$mod = Module_KassiererCard::instance();
		$mod->increaseConfigVar('coupons_created');
		$mod->increaseConfigVar('stars_created', $gdo->getStars());

		$user = $gdo->getCreator();
		$user->increaseSetting('KassiererCard', 'coupons_created');
		$user->increaseSetting('KassiererCard', 'stars_created', $gdo->getStars());
	}
	
	public function onPrinted() : void
	{
		if (!$this->isPrinted())
		{
			$this->saveVar('kc_printed', Time::getDate());
			Module_KassiererCard::instance()->increaseConfigVar('coupons_printed');
		}
	}
	
	/**
	 * Coupon got entered either as signup key or normal coupon.
	 * @param bool $isActivation - Is triggered by signup activation?
	 */
	public function entered(GDO_User $user, bool $isActivation=false): void
	{
		$kk = Module_KassiererCard::instance();
		$kkn = $kk->getModuleName();
		$stars = $this->getStars();
		$creator = $this->getCreator();
		$this->saveVars([
			'kc_entered' => Time::getDate(),
			'kc_enterer' => $user->getID(),
		]);
		
		$user->increaseSetting($kkn, 'stars_available', $stars);
		$user->increaseSetting($kkn, 'stars_entered', $stars);
		$user->increaseSetting($kkn, 'stars_earned', $stars);
		
		$creator->increaseSetting($kkn, 'diamonds_available', $stars);
		$creator->increaseSetting($kkn, 'diamonds_earned', $stars);
		$this->sendCreatorEarnedStars($creator, $user, $stars);
		
		$kk->increaseConfigVar('coupons_entered');
		$kk->increaseConfigVar('stars_entered', $stars);
		$kk->increaseConfigVar('diamonds_created', $stars);
		if ($isActivation)
		{
			if ($this->isUserInvitation())
			{
				$level = $this->levelForStars();
				$diamonds = $this->diamondsForInvitation();
				$kk->increaseConfigVar('users_invited');
				$kk->increaseConfigVar('stars_invited', $stars);
				$kk->increaseConfigVar('diamonds_created', $diamonds);
				$creator->increaseSetting($kkn, 'users_invited');
				$creator->increaseSetting($kkn, 'stars_available', $stars);
				$creator->increaseSetting($kkn, 'stars_earned', $stars);
				$creator->increaseSetting($kkn, 'stars_invited', $stars);
				$creator->increaseSetting($kkn, 'diamonds_earned', $diamonds);
				$creator->increase('user_level', $level);
				$this->sendDiamondMail($user, $diamonds, $level);
			}
		}
	}
	
	private function levelForStars(): int
	{
		return $this->getStars();
	}
	
	private function diamondsForInvitation(): int
	{
		return $this->getStars();
	}
	
	private function sendCreatorEarnedStars(GDO_User $customer, GDO_User $cashier, int $stars): void
	{
		$mail = Mail::botMail();
		$mail->setSubject(tusr($customer, 'mail_subj_customer_stars', [sitename(), $stars]));
		$args = [
			$customer->renderUserName(),
			$cashier->renderUserName(),
			$stars,
			$stars,
			sitename(),
		];
		$mail->setBody(tusr($customer, 'mail_body_customer_stars', $args));
		$mail->sendToUser($customer);
	}
	
	public static function onActivation(GDO_User $user, ?string $token): void
	{
		if ($code = self::getByToken($token))
		{
			if ($type = $code->getType())
			{
				GDO_UserPermission::grant($user, $type);
				$user->changedPermissions();
			}
			
			$code->entered($user, true);
			
			if ($code->getStars())
			{
				Website::message('KassiererCard', 'msg_signup_stars', [
					sitename(),
					$code->getStars(),
					KC_Util::numStarsAvailable($user),
				]);
			}
		}
		else
		{
			GDO_UserPermission::grant($user, 'kk_customer');
			$user->changedPermissions();
			Website::message('KassiererCard', 'msg_signup_customer_no_token');
		}
	}
	
	private function sendDiamondMail(GDO_User $newUser, int $diamonds, int $level): void
	{
		$creator = $this->getCreator();
		$mail = Mail::botMail();
		$mail->setSubject(tusr($creator, 'mail_subj_kk_invited_diamonds', [sitename(), html($newUser->getMail())]));
		$mail->setBody(tusr($creator, 'mail_body_kk_invited_diamonds', [
			$creator->renderUserName(),
			$newUser->renderUserName(),
			$newUser->getMail(),
			sitename(),
			$this->getStars(),
			$diamonds,
			KC_Util::numDiamondsTotal($creator),
			$level,
			$creator->getLevel(),
		]));
		$mail->sendToUser($creator);
	}
	
	##############
	### Images ###
	##############
	public function getFrontSide() : GDT_Image
	{
		$href = $this->hrefSVGFrontBack('Front');
		return GDT_SVGImage::make('front')->src($href);
	}
	
	public function getFrontSideFlyer() : GDT_Image
	{
		$href = $this->hrefSVGFrontBack('FrontFlyer');
		return GDT_SVGImage::make('front')->src($href);
	}
	
	public function getBackSide() : GDT_Image
	{
		# Our invitation back
		if ($this->isInvitation())
		{
			return $this->getBackSideKC();
		}

		# Company's offer image
		if ($offer = $this->getOffer())
		{
			if ($imageFile = $offer->getBacksideImage())
			{
				return GDT_Image::fromFile($imageFile, 'back');
			}
		}

		# Our coupon back (Advertise here)
		return $this->getBackSideKC();
	}
	
	private function getBackSideKC() : GDT_SVGImage
	{
		$href = $this->hrefSVGFrontBack('Back');
		return GDT_SVGImage::make('back')->src($href);
	}
	
	##################
	### Permission ###
	##################
	public function canPrint(GDO_User $user) : bool
	{
		if ($user->isStaff())
		{
			return true;
		}
		return $user === $this->getCreator();
	}
	
	###############
	### QR-Code ###
	###############
	public function getQRCode() : GDT_QRCode
	{
		return $this->getQRCodeWithData($this->urlEnter());
	}
	
	public function getQRCodeWithData(string $data) : GDT_QRCode
	{
		return GDT_QRCode::make()->qrcodeSize($this->qrcodeSize())->var($data);
	}
	
	private function qrcodeSize()
	{
		return Module_KassiererCard::instance()->cfgQRCodeSize();
	}
	
	############
	### HREF ###
	############
	public function href_delete(): string
	{
		return href('KassiererCard', 'AdminCouponDelete', "&coupon={$this->getID()}");
	}
	
	public function hrefSVGFrontBack(string $FrontBack='Front') : string
	{
		$type = $this->getType();
		$token = $this->getToken();
		
		if ($FrontBack === 'FrontFlyer')
		{
			return href('KassiererCard', "Invitation{$FrontBack}Side", "&token={$token}");
		}
		
		switch ($type)
		{
			case 'kk_coupon':
				return href('KassiererCard', "{$FrontBack}Side", "&token={$token}");
			case 'kk_cashier':
			case 'kk_company':
			case 'kk_customer':
				return href('KassiererCard', "Invitation{$FrontBack}Side", "&token={$token}");
			default:
				return href('Register', 'InvalidCoupon', "&token={$token}&type={$type}");
		}
	}
	
	public function hrefEnter() : string
	{
		$type = $this->getType();
		$token = $this->getToken();
		switch ($type)
		{
			case 'kk_coupon':
				return href('KassiererCard', 'EnterCoupon', "&token={$token}");
			case 'kk_cashier':
			case 'kk_company':
			case 'kk_customer':
				return href('Register', 'Form', "&kk_token={$token}&kk_type={$type}");
			default:
				return href('KassiererCard', 'InvalidCoupon', "&token={$token}&type={$type}");
		}
	}
	
	public function urlEnter() : string
	{
		return GDT_Url::absolute($this->hrefEnter());
	}
	
	public function href_print(): string
	{
		return href('KassiererCard', 'PrintCoupon', "&token={$this->getID()}");
	}
	
	##############
	### Render ###
	##############
	public function renderPrinted() : string
	{
		return tt($this->getPrinted());
	}
	
	public function renderType() : string
	{
		return $this->gdoColumn('kc_type')->renderVar();
	}
	
	public function renderList() : string
	{
		return GDT_Template::php('KassiererCard', 'coupon_list.php', ['gdo' => $this]);
	}
	
	public function renderSlogan() : string
	{
		return html($this->getSlogan());
	}
		
	public function renderInvitationSlogan() : string
	{
		return t('kk_invite_slogan', [$this->renderType()]);
	}
	
	##############
	### Static ###
	##############
	public static function numCouponsCreated(GDO_User $user) : int
	{
		return self::table()->countWhere("kc_creator={$user->getID()}");
	}
	
	public static function numStarsCreated(GDO_User $user, int $periodStart) : int
	{
		$periodEnd = $periodStart + Time::ONE_DAY * 2;
		$periodEnd = Time::getDate($periodEnd);
		$periodStart = Time::getDate($periodStart);
		$query = self::table()->select('SUM(kc_stars)')
			->where("kc_created >= '$periodStart' AND kc_created < '$periodEnd'")
			->where("kc_creator={$user->getID()}");
		return (int) $query->exec()->fetchValue();
	}
	
	########################
	### Get Rate Limited ###
	########################
	public static function getByToken(?string $token, bool $entered=false) : ?self
	{
		if ($token)
		{
			$reason = '';
			if (KC_TokenRequest::isBlocked(GDO_User::current(), $reason))
			{
				Website::error(sitername(), '%s', [$reason]);
				return null;
			}
			if ($coupon = self::getBy('kc_token', $token))
			{
				return $coupon->isEntered() === $entered
					? $coupon : null;
			}
		}
		return null;
	}
	
	#################
	### Demo Card ###
	#################
	public static function demoCoupon(): self
	{
		return self::getBy('kc_token', 'KASSIERERS');
	}
	
}
