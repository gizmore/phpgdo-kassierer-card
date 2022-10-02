<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Badge;
use GDO\UI\GDT_Page;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;
use GDO\UI\GDT_Card;
use GDO\Form\GDT_Form;
use GDO\Register\GDO_UserActivation;
use GDO\User\GDO_UserPermission;
use GDO\UI\GDT_Bar;
use GDO\Core\GDT_UInt;
use GDO\Core\GDT_String;
use GDO\Form\GDT_Validator;
use GDO\Core\GDT;
use GDO\Core\Website;
use GDO\Net\GDT_Url;
use GDO\UI\GDT_Length;
use GDO\User\GDT_ACLRelation;
use GDO\UI\GDT_Divider;
use GDO\Core\Javascript;
use GDO\Core\GDT_Checkbox;

/**
 * KassiererCard.org - At least we try! 
 * 
 * @author gizmore
 * @since 7.0.1
 */
final class Module_KassiererCard extends GDO_Module
{
	public int $priority = 125;
	
	public function getTheme() : ?string { return 'kkorg'; }
	
	public function isSiteModule(): bool
	{
		return true;
	}
	
	public function href_administrate_module() : ?string
	{
		return $this->href('Admin');
	}
	
	public function getDependencies() : array
	{
		return [
			'Account', 'ActivationAlert', 'Address',
			'Admin', 'Ads', 'Avatar',
			'Backup', 'Birthday', 'Bootstrap5Theme',
			'Category', 'Contact', 'Classic',
			'CountryRestrictions', 'CSS',
			'DoubleAccounts',
			'FontAtkinson', 'FontAwesome', 'Forum',
			'IP2Country',
			'Javascript', 'JQueryAutocomplete',
			'Licenses', 'Links', 'Login',
			'Maps', 'Mail', 'Maps', 'Markdown',
			'News', 'PM', 'QRCode', 'Recovery', 'Register',
			'YouTube',
		];
	}
	
	public function getClasses() : array
	{
		return [
			KC_Business::class,
			KC_Coupon::class,
			KC_Partner::class,
			KC_Offer::class,
			KC_CouponRedeemed::class,
			KC_SignupCode::class,
			KC_Slogan::class,
			KC_Working::class,
		];
	}
	
	##############
	### Config ###
	##############
	public function getConfig() : array
	{
		return [
			GDT_Checkbox::make('pre_alpha')->initial('0'),
			GDT_UInt::make('free_stars_per_period')->min(0)->max(100)->initial('2'),
			GDT_UInt::make('level_per_coupon_print')->min(0)->max(1000)->initial('1'),
			GDT_UInt::make('customer_coupon_modulus')->min(1)->initial('5'),
		];
	}
	public function cfgPreAlpha() : bool { return $this->getConfigValue('pre_alpha'); }
	public function cfgFreeStarsPerPeriod() : int { return $this->getConfigValue('free_stars_per_period'); }
	public function cfgLevelPerPrintedCoupon() : int { return $this->getConfigValue('level_per_coupon_print'); }
	public function cfgCustomerCouponModulus() : int { return $this->getConfigValue('customer_coupon_modulus'); }
	
	################
	### Settings ###
	################
	public function getUserConfig() : array
	{
		return [
			GDT_Badge::make('stars_purchased')->tooltip('tt_stars_purchased')->icon('money'),
			GDT_Badge::make('stars_purchased_total')->tooltip('tt_stars_purchased_total')->icon('money'),
			GDT_Badge::make('stars_created')->tooltip('tt_stars_created')->icon('bee'),
			GDT_Badge::make('stars_entered')->tooltip('tt_stars_entered')->icon('bee'),
			GDT_Badge::make('stars_available')->tooltip('tt_stars_available')->icon('sun'),
			GDT_Badge::make('stars_redeemed')->tooltip('tt_stars_redeemed')->icon('star'),
			GDT_Badge::make('offers_redeemed')->tooltip('tt_offers_redeemed')->icon('star'),
			GDT_Badge::make('offers_created')->tooltip('tt_offers_created')->icon('star'),
			GDT_Badge::make('diamonds_earned')->tooltip('tt_diamonds_earned')->icon('sun'),
		];
	}
	
	public function getACLDefaults() : ?array
	{
		return [
			# Profile
			'profession' => [GDT_ACLRelation::MEMBERS, 0, null],
			'personal_website' => [GDT_ACLRelation::MEMBERS, 0, null],
			'favorite_website' => [GDT_ACLRelation::ALL, 0, null],
			'favorite_meal' => [GDT_ACLRelation::FRIENDS, 0, null],
			'favorite_song' => [GDT_ACLRelation::FRIENDS, 0, null],
			'favorite_movie' => [GDT_ACLRelation::FRIENDS, 0, null],
			'your_dream' => [GDT_ACLRelation::FRIENDS, 0, null],
			# UI
			'qrcode_size' => [GDT_ACLRelation::HIDDEN, 0, null],
		];
	}
	
	public function getUserSettings() : array
	{
		return [
			GDT_Divider::make('div_kk'),
			GDT_String::make('profession')->initial('Kassierer')->icon('work'),
			GDT_Url::make('personal_website')->allowExternal(),
			GDT_Url::make('favorite_website')->allowExternal()->icon('trophy'),
			GDT_String::make('favorite_meal')->icon('trophy'),
			GDT_String::make('favorite_song')->icon('trophy'),
			GDT_String::make('favorite_movie')->icon('trophy'),
			GDT_String::make('your_dream')->icon('spiderweb'),
			GDT_Divider::make('div_ui'),
			GDT_Length::make('qrcode_size')->initial('320')->noacl(),
		];
	}
	
	public function cfgQRCodeSize() : int
	{
		return $this->userSettingVar(GDO_User::current(), 'qrcode_size');
	}
	
	############
	### Init ###
	############
	public function onLoadLanguage() : void
	{
	    $this->loadLanguage('lang/faq');
	    $this->loadLanguage('lang/kassierercard');
	}
	
	public function onInstall() : void
	{
		Install::install($this);
	}
	
	public function onInitSidebar() : void
	{
		$page = GDT_Page::instance();
		$user = GDO_User::current();
		
		$page->leftBar()->addFieldFirst(
			GDT_Link::make('link_kk_home')->icon('cc')->href($this->href('Welcome')),
		);

		$numOffers = KC_Offer::queryNumActive();
		
		$page->leftBar()->addFields(
			GDT_Link::make()->href($this->href('Offers'))->text('link_kk_offers', [$numOffers])->icon('star'),
			GDT_Link::make('link_kk_businesses')->href($this->href('Businesses'))->textArgs(KC_Business::numTotal())->icon('house'),
			GDT_Link::make('link_kk_partners')->href($this->href('Partners'))->textArgs(KC_Partner::numTotal())->icon('icecream'),
			GDT_Link::make('link_kk_employees')->href($this->href('Employees'))->textArgs(KC_Working::numEmployeesTotal())->icon('work'),
			GDT_Link::make('link_kk_team')->href($this->href('Team'))->textArgs(8)->icon('users'),
			GDT_Link::make('link_kk_help')->href($this->href('Help'))->icon('help'),
		);
		
		if ($user->isUser())
		{
			if ($this->canCreateCoupons($user))
			{
				$page->rightBar()->addFields(
					GDT_Link::make('create_coupon')->href($this->href('CreateCoupon'))->icon('bee'),
				);
			}
			
			if ($this->isCashier($user))
			{
				$page->rightBar()->addFields(
					GDT_Link::make('enter_coupon')->href($this->href('EnterCoupon'))->icon('bee'),
				);
			}
			
			if ($this->canCreateCoupons($user))
			{
				$page->rightBar()->addFields(
					GDT_Link::make('redeem_coupon')->href($this->href('RedeemOffer'))->icon('sun'),
					GDT_Link::make('entered_coupons')->href($this->href('EnteredCoupons'))->icon('star'),
					GDT_Badge::make()->icon('sun')->tooltip('tt_stars_available')->text('stars_available')->var(KC_Util::numStarsAvaliable($user)),
					GDT_Badge::make()->icon('sun')->tooltip('tt_coupons_available')->text('coupons_available')->var(KC_Util::numCouponsAvailable($user)),
				);
			}
			
			if ($this->isCompany($user))
			{
				$page->rightBar()->addFields(
					GDT_Link::make('businesses')->href($this->href('CompanyBusinesses')),
					GDT_Link::make('create_offer')->href($this->href('CreateOffer')),
				);
			}
			
			if ($this->isDistributor($user))
			{
				$page->rightBar()->addFields(
					GDT_Link::make('create_business')->href($this->href('BusinessCrud'))->icon('add'),
					GDT_Link::make('create_company')->href($this->href('CompanyCrud'))->icon('add'),
				);
			}
			
			if ($user->isStaff())
			{
				$page->rightBar()->addFields(
					GDT_Link::make('kk_admin')->href($this->href('Admin')),
				);
			}
		}
	}
	
	private function canCreateCoupons(GDO_User $user)
	{
		return
			$user->hasPermission('kk_customer') ||
			$user->hasPermission('kk_cashier');
	}
	
	public function onModuleInit() : void
	{
		Website::addLink([
			'rel' => 'icon',
			'href' => $this->wwwPath('img/kassierercard_logo.svg'),
			'type' => 'image/svg+xml',
			'sizes' => 'any',
		]);
	}
	
	public function onIncludeScripts() : void
	{
		$this->addJS('js/kk.js');
		$this->addCSS('css/kk.css');
		if ($this->cfgPreAlpha())
		{
			$script_html = 'alert("Dies ist eine fiktivie Vorabversion. Sobald diese Nachricht nicht mehr erscheint startet Phase 1.");';
			Javascript::addJSPostInline($script_html);
		}
	}
	
	#################
	### User type ###
	#################
	public function isManager(GDO_User $user) : bool
	{
		return $this->isType($user, GDT_AccountType::MANAGER);
	}
	
	public function isDistributor(GDO_User $user) : bool
	{
		return $this->isType($user, GDT_AccountType::DISTRIBUTOR);
	}
	
	public function isCashier(GDO_User $user) : bool
	{
		return $this->isType($user, GDT_AccountType::CASHIER);
	}
	
	public function isCompany(GDO_User $user) : bool
	{
		return $this->isType($user, GDT_AccountType::COMPANY);
	}
	
	public function isCustomer(GDO_User $user) : bool
	{
		return $this->isType($user, GDT_AccountType::CUSTOMER);
	}
	
	public function isType(GDO_User $user, string $type) : bool
	{
		return $user->hasPermission($type);
	}
	
	############
	### Hook ###
	############
	public function hookCreateCardUserProfile(GDT_Card $card)
	{
		$user = $card->gdo->getUser();
		$disabled = !$this->isCustomer($user);
		$linkPM = GDT_Link::make()->href($this->href('SendCoupons', '&user='.$user->renderUserName()))->label('btn_send_coupons')->disabled($disabled);
		$card->actions()->addField($linkPM);
	}
	
	public function hookRegisterForm(GDT_Form $form)
	{
	    $type = GDT_AccountType::make('kk_type')->notNull()->tooltip('tt_kk_type')->icon('info');
	    $form->addFieldAfterName($type, 'user_name');
	    $code = GDT_String::make('kk_token')->label('lbl_kk_register_code')->tooltip('tt_kk_register_code');
	    $form->addFieldAfterName($code, 'kk_type');
	    $vali = GDT_Validator::make('kk_valid_token')->validator($form, $code, [$this, 'validateToken']);
	    $form->addFieldAfterName($vali, 'kk_token');
	    $form->text('kk_info_register');
	}
	
	public function validateToken(GDT_Form $form, GDT $field, $value)
	{
		if ($type = $form->getFormVar('kk_type'))
		{
			if ($type !== 'kk_customer')
			{
				if (!(KC_SignupCode::validateCode($value?$value:'', $type)))
				{
					$field->error('err_kk_signup_code');
					return false;
				}
			}
		}
		return true;
	}
	
	public function hookOnRegister(GDT_Form $form, GDO_UserActivation $activation)
	{
		$data = $activation->gdoValue('ua_data');
		$data['kk_type'] = $form->getFormVar('kk_type');
		$data['kk_token'] = $form->getFormVar('kk_token');
		$activation->setValue('ua_data', $data);
	}
	
	/**
	 * Upon activation, grant usertype permission and delete the signup-code.
	 */
	public function hookUserActivated(GDO_User $user, GDO_UserActivation $activation = null) : void
	{
		if ($activation)
		{
			$data = $activation->gdoValue('ua_data');
			if (@$data['kk_type'])
			{
				GDO_UserPermission::grant($user, $data['kk_type']);
			}
			if (@$data['kk_token'])
			{
				KC_SignupCode::clearCode($data['kk_token']);
			}
		}
	}
	
	################
	### Top Bars ###
	################
	public function addAdminBar() : void
	{
		$bar = GDT_Bar::make()->horizontal();
		$bar->addFields(
			GDT_Link::make('generate_signup_code')->href($this->href('AdminCreateSignupCode'))->icon('create'),
			GDT_Link::make('signup_codes')->href($this->href('AdminSignupCodes'))->icon('list'),
		);
		GDT_Page::instance()->topResponse()->addField($bar);
	}
	
	public function addCustomerBar() : void
	{
		$bar = GDT_Bar::make()->horizontal();
		$bar->addFields(
			GDT_Link::make('generate_coupons')->href($this->href('CreateCoupon')),
			GDT_Link::make('printed_coupons')->href($this->href('PrintedCoupons')),
			GDT_Link::make('granted_coupons')->href($this->href('GrantedCoupons')),
		);
		GDT_Page::instance()->topResponse()->addField($bar);
	}
	
	public function addCashierBar() : void
	{
		$bar = GDT_Bar::make()->horizontal();
		$bar->addFields(
			GDT_Link::make('enter_coupon')->href($this->href('EnterCoupon')),
			GDT_Link::make('granted_coupons')->href($this->href('GrantedCoupons')),
		);
		GDT_Page::instance()->topResponse()->addField($bar);
	}

	public function addCompanyBar() : void
	{
		$bar = GDT_Bar::make()->horizontal();
		$bar->addFields(
			GDT_Link::make('create_card')->href($this->href('CompanyCreateCard')),
			GDT_Link::make('edit_business')->href($this->href('CompanyEditBusiness')),
		);
		GDT_Page::instance()->topResponse()->addField($bar);
	}
	
	### helprt
	
	public function linkOffers() : GDT_Link
	{
		$href = href('KassiererCard', 'Offers');
		return GDT_Link::make('offers')->href($href);
	}
	
}
