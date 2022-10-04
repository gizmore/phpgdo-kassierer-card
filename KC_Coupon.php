<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_Template;
use GDO\User\GDO_User;
use GDO\Date\Time;
use GDO\Core\GDT_Index;
use GDO\Date\GDT_Timestamp;
use GDO\User\GDT_User;
use GDO\Net\GDT_Url;
use GDO\QRCode\GDT_QRCode;
use GDO\UI\GDT_Image;
use GDO\UI\GDT_SVGImage;

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
			GDT_CouponStars::make('kc_stars'),
			GDT_Offer::make('kc_offer')->emptyLabel('sel_coupon_offer'),
			GDT_CreatedBy::make('kc_creator'),
			GDT_CreatedAt::make('kc_created'),
			GDT_Timestamp::make('kc_printed'),
			GDT_User::make('kc_enterer'),
			GDT_Timestamp::make('kc_entered'),
			GDT_Index::make('index_offers')->indexColumns('kc_offer'),
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
		$user->increase('stars_created', $gdo->getStars());
		$user->increase('coupons_created', $gdo->getStars());
	}
	
	public function onPrinted() : void
	{
		if (!$this->isPrinted())
		{
			$this->saveVar('kc_printed', Time::getDate());
			$user = GDO_User::current();
			$user->increase('coupons_printed', $this->getStars());
		}
	}
	
	public function onEntered() : void
	{
		
	}
	
	##############
	### Images ###
	##############
	public function getFrontSide() : GDT_Image
	{
		$href = $this->hrefSVGFrontBack('Front');
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
	public function hrefSVGFrontBack(string $FrontBack='Front') : string
	{
		$type = $this->getType();
		$token = $this->getToken();
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
				return href('Register', 'InvalidCoupon', "&token={$token}&type={$type}");
		}
	}
	
	public function urlEnter() : string
	{
		return GDT_Url::absolute($this->hrefEnter());
	}
	
	#############
	### Enter ###
	#############
	public function entered(GDO_User $user)
	{
		$stars = $this->getStars();
		$this->saveVars([
			'kc_entered' => Time::getDate(),
			'kc_enterer' => $user->getID(),
		]);
		$user->increaseSetting('KassiererCard', 'stars_earned', $stars);
		$user->increaseSetting('KassiererCard', 'stars_entered', $stars);
		$user->increaseSetting('KassiererCard', 'stars_available', $stars);
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
	
	/**
	 * Create a coupon for a signup code.
	 */
	public static function createSignupCoupon(KC_SignupCode $code) : self
	{
		return self::blank([
			'kc_token' => $code->getToken(),
			'kc_type' => $code->getType(),
			'kc_stars' => $code->getStars(),
		])->insert();
	}
	
	########################
	### Get Rate Limited ###
	########################
	public static function getByToken(string $token) : ?self
	{
		return self::getBy('kc_token', $token);
	}
	
}
