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
			'Account', 'ActivationAlert', 'Address', 'Admin', 'Avatar',
			'Backup', 'Birthday', 'Bootstrap5Theme',
			'Category', 'Contact', 'Classic',
			'CountryRestrictions', 'CSS',
			'DoubleAccounts',
			'FontAtkinson', 'FontAwesome', 'Forum',
			'Invite', 'IP2Country',
			'Javascript', 'JQueryAutocomplete',
			'Licenses', 'Links', 'Login',
			'Maps', 'Mail', 'Maps', 'Markdown',
			'News', 'PM', 'QRCode', 'Recovery', 'Register',
		];
	}
	
	public function getClasses() : array
	{
		return [
			KC_Business::class,
			KC_Working::class,
			KC_Coupon::class,
			KC_Partner::class,
			KC_Offer::class,
			KC_CouponRedeemed::class,
			KC_SignupCode::class,
			KC_Slogan::class,
		];
	}
	
	##############
	### Config ###
	##############
	public function getConfig() : array
	{
		return [
			GDT_UInt::make('free_stars_per_period')->min(0)->max(100)->initial('2'),
			GDT_UInt::make('level_per_coupon_print')->min(0)->max(1000)->initial('1'),
		];
	}
	public function cfgFreeStarsPerPeriod() : int { return $this->getConfigValue('free_stars_per_period'); }
	public function cfgLevelPerPrintedCoupon() : int { return $this->getConfigValue('level_per_coupon_print'); }
	
	
	################
	### Settings ###
	################
	public function getUserConfig() : array
	{
		return [
			GDT_Badge::make('coupons_created')->tooltip('tt_coupons_created')->icon('bee'),
			GDT_Badge::make('coupons_entered')->tooltip('tt_coupons_entered')->icon('sun'),
			GDT_Badge::make('coupons_available')->tooltip('coupons_available')->icon('sun'),
			GDT_Badge::make('coupons_redeemed')->tooltip('tt_coupons_redeemed')->icon('star'),
			GDT_Badge::make('offers_taken')->tooltip('tt_offers_taken')->icon('star')->iconColor('yellow'),
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
			# UI
			'qrcode_size' => [GDT_ACLRelation::HIDDEN, 0, null],
		];
	}
	
	public function getUserSettings() : array
	{
		return [
			GDT_Divider::make('div_kk'),
			GDT_String::make('profession')->initial('Kassierer'),
			GDT_Url::make('personal_website')->allowExternal(),
			GDT_Url::make('favorite_website')->allowExternal(),
			GDT_String::make('favorite_meal'),
			GDT_String::make('favorite_song'),
			GDT_String::make('favorite_movie'),
			GDT_Divider::make('div_ui'),
			GDT_Length::make('qrcode_size')->initial('512')->noacl(),
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
		
		$page->leftBar()->addFields(
			GDT_Link::make('link_kk_home')->icon('cc')->href($this->href('Welcome')),
			GDT_Link::make('link_kk_offers')->href($this->href('Offers')),
			GDT_Link::make('link_kk_businesses')->href($this->href('Businesses')),
			GDT_Link::make('link_kk_partners')->href($this->href('Partners')),
			GDT_Link::make('link_kk_employees')->href($this->href('Employees')),
			GDT_Link::make('link_kk_help')->href($this->href('Help')),
		);
		
		if ($user->isUser())
		{
			if ($this->isCustomer($user))
			{
				$page->rightBar()->addFields(
					GDT_Link::make('create_coupon')->href($this->href('CreateCoupon')),
					GDT_Link::make('printed_coupons')->href($this->href('PrintedCoupons')),
				);
			}
			
			if ($this->isCashier($user))
			{
				$page->rightBar()->addFields(
					GDT_Link::make('enter_coupon')->href($this->href('EnterCoupon')),
					GDT_Link::make('redeem_coupon')->href($this->href('RedeemCoupon')),
					GDT_Link::make('entered_coupons')->href($this->href('EnteredCoupons')),
				);
				$page->rightBar()->addFields(
					GDT_Badge::make()->icon('sun')->tooltip('tt_coupons_available')->label('coupons_available')->var($user->settingVar('KassiererCard', 'coupons_available')),
				);
			}
			
			if ($this->isCompany($user))
			{
				$page->rightBar()->addFields(
					GDT_Link::make('businesses')->href($this->href('CompanyBusinesses')),
					GDT_Link::make('create_offer')->href($this->href('CreateOffer')),
				);
			}
		}
		
// 		$page->bottomBar()->addFields(
// 			GDT_Link::make('link_kk_partners')->href($this->href('Partners')),
// 		);
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
	
	#################
	### User type ###
	#################
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
		$type = $form->getFormVar('kk_type');
		if ($type === 'kk_cashier')
		{
			if (!(KC_SignupCode::validateCode($value)))
			{
				$field->error('err_kk_signup_code');
				return false;
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
			GDT_Link::make('generate_signup_code')->href($this->href('AdminCreateSignupCode')),
			GDT_Link::make('signup_codes')->href($this->href('AdminSignupCodes')),
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
