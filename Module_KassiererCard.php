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
use GDO\Payment\GDT_Money;

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
			'Account', 'AboutMe', 'ActivationAlert', 'Address',
			'Admin', 'Ads', 'Avatar',
			'Backup', 'Birthday', 'Bootstrap5Theme',
			'Category', 'Contact', 'Classic',
			'CountryCoordinates', 'CountryRestrictions', 'CSS',
			'DoubleAccounts',
			'FontAtkinson', 'FontAwesome', 'Forum',
			'IP2Country',
			'Javascript', 'JQueryAutocomplete',
			'Licenses', 'Links', 'LoC', 'Login',
			'Maps', 'Mail', 'Maps', 'Markdown', 'News',
			'Perf', 'Poll', 'PM', 'QRCode',
			'Recovery', 'Register',
			'YouTube',
		];
	}
	
	public function getClasses() : array
	{
		return [
			KC_Partner::class,
			KC_Business::class,
			KC_Coupon::class,
			KC_Offer::class,
			KC_OfferRedeemed::class,
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
			# Alert!
			GDT_Checkbox::make('pre_alpha')->initial('0'),
			# Balance
			GDT_UInt::make('stars_per_euro')->min(1)->max(100)->initial('10'),
			GDT_UInt::make('free_stars_per_period')->min(0)->max(100)->initial('2'),
			GDT_UInt::make('level_per_coupon_print')->min(0)->max(1000)->initial('1'),
			GDT_UInt::make('customer_coupon_modulus')->min(1)->initial('5'),
			# Stats
			GDT_Badge::make('coupons_created')->initial('0')->label('cfg_coupons_created')->tooltip('tt_cfg_coupons_created'),
			GDT_Badge::make('coupons_printed')->initial('0')->label('cfg_coupons_printed')->tooltip('tt_cfg_coupons_printed'),
			GDT_Badge::make('coupons_entered')->initial('0')->label('cfg_coupons_entered')->tooltip('tt_cfg_coupons_entered'),
			GDT_Badge::make('stars_created')->initial('0')->label('cfg_stars_created')->tooltip('tt_cfg_stars_created'),
			GDT_Badge::make('stars_purchased')->initial('0')->label('cfg_stars_created')->tooltip('tt_cfg_stars_created'),
			GDT_Badge::make('stars_entered')->initial('0')->label('cfg_stars_created')->tooltip('tt_cfg_stars_created'),
			GDT_Badge::make('stars_redeemed')->initial('0')->label('cfg_stars_redeemed')->tooltip('tt_cfg_stars_redeemed'),
			GDT_Badge::make('offers_created')->initial('0')->label('cfg_offers_created')->tooltip('tt_cfg_offers_created'),
			GDT_Badge::make('offers_redeemed')->initial('0')->label('cfg_offers_redeemed')->tooltip('tt_cfg_offers_redeemed'),
			GDT_Money::make('euros_invested')->initial('0.00')->label('cfg_euros_invested')->tooltip('tt_cfg_euros_invested'),
			GDT_Money::make('euros_generated')->initial('0.00')->label('cfg_euros_invested')->tooltip('tt_cfg_euros_invested'),
			GDT_Money::make('euros_earned')->initial('0.00')->label('cfg_euros_earned')->tooltip('tt_cfg_euros_earned'),
			GDT_Money::make('euros_revenue')->initial('0.00')->label('cfg_euros_revenue')->tooltip('tt_cfg_euros_revenue'),
		];
	}
	public function cfgPreAlpha() : bool { return $this->getConfigValue('pre_alpha'); }
	public function cfgStarsPerEuro() : int { return $this->getConfigValue('stars_per_euro'); }
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
			GDT_Badge::make('stars_created')->tooltip('tt_stars_created')->icon('bee'),
			GDT_Badge::make('stars_entered')->tooltip('tt_stars_entered')->icon('bee'),
			GDT_Badge::make('stars_earned')->tooltip('tt_stars_earned')->icon('bee'),
			GDT_Badge::make('stars_available')->tooltip('tt_stars_available')->icon('sun'),
			GDT_Badge::make('stars_redeemed')->tooltip('tt_stars_redeemed')->icon('star'),
			GDT_Badge::make('offers_redeemed')->tooltip('tt_offers_redeemed')->icon('star'),
			GDT_Badge::make('offers_created')->tooltip('tt_offers_created')->icon('star'),
			GDT_Badge::make('offers_fullfilled')->tooltip('tt_offers_fullfilled')->icon('bee'),
			GDT_Badge::make('offers_fullfilled')->tooltip('tt_stars_fullfilled')->icon('bee'),
			GDT_Badge::make('diamonds_earned')->tooltip('tt_diamonds_earned')->icon('sun'),
			GDT_Money::make('euros_fullfilled')->tooltip('tt_euros_fullfilled')->label('cfg_euros_fullfilled'),
			GDT_Money::make('euros_invested')->tooltip('tt_cfg_euros_invested')->label('cfg_euros_invested'),
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
			GDT_String::make('profession')->icon('work'),
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
		
		$page->leftBar()->addFields(
			GDT_LeftMenu::make(),
		);
		
		if ($user->isUser())
		{
			$rb = $page->rightBar();
			
			if ($this->isCashier($user))
			{
				$rb->addFields(
					GDT_CashierMenu::make('kk_cashier_menu'),
				);
			}
			
			if ($this->isCompany($user))
			{
				$rb->addFields(
					GDT_PartnerMenu::make('kk_company_menu'),
				);
			}
			
			if ($this->isCustomer($user))
			{
				$rb->addFields(
					GDT_CustomerMenu::make('kk_customer_menu'),
				);
			}
			
			if ($this->isDistributor($user))
			{
				$rb->addFields(
					GDT_DistributorMenu::make('kk_customer_menu'),
				);
			}
			
			if ($user->isStaff())
			{
				$rb->addFields(
					GDT_Link::make('kk_admin')->href($this->href('Admin')),
				);
			}
		}
	}
	
	private function canCreateCoupons(GDO_User $user)
	{
		return $user->hasPermission('kk_customer','kk_company');
	}
	
	private function canRedeemOffers(GDO_User $user)
	{
		return $user->hasPermission('kk_customer,kk_cashier');
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
		$code = GDT_SignupCode::make('kk_token')->label('lbl_kk_register_code')->tooltip('tt_kk_register_code');
		$type = GDT_AccountType::make('kk_type')->notNull();
		$form->addFieldAfterName($code, 'user_name');
		$form->addFieldAfterName($type, 'kk_token');
	    $vali = GDT_Validator::make('kk_valid_token')->validator($form, $code, [$this, 'validateToken']);
	    $form->addFieldAfterName($vali, 'kk_token');
	    $form->text('kk_info_register');
	}
	
	public function validateToken(GDT_Form $form, GDT $field, $value)
	{
		if ($code = $form->getFormVar('kk_token'))
		{
			if (!($code = KC_SignupCode::getBy('sc_token', $code)))
			{
				return $field->error('err_kk_signup_code_unknown');
			}
		}
		
		$type = $form->getFormVar('kk_type');
		
		if ($type === 'kk_customer')
		{
			if ($code)
			{
				return $field->error('err_kk_signup_customer_no_code');
			}
			return true;
		}
		
		if (!$code)
		{
			return $field->error('err_kk_signup_code_required');
		}
		
		if ($type !== $code->getType())
		{
			return $field->error('err_kk_signup_code_type', [$code->renderType()]);
		}
		
		return true;
	}
	
	public function hookOnRegister(GDT_Form $form, GDO_UserActivation $activation)
	{
		$data = $activation->gdoValue('ua_data');
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
			KC_SignupCode::onActivation($user, @$data['kk_token']);
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
			GDT_Link::make('grant_stars')->href($this->href('AdminGrantStars'))->icon('star'),
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
	
// 	### helprt
	
// 	public function linkOffers() : GDT_Link
// 	{
// 		$href = href('KassiererCard', 'Offers');
// 		return GDT_Link::make('offers')->href($href);
// 	}
	
}
