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

/**
 * KassiererCard.org - At least we try! 
 * 
 * @author gizmore
 * @since 7.0.1
 */
final class Module_KassiererCard extends GDO_Module
{
	public int $priority = 25;
	
	public function getTheme() : ?string { return 'kkorg'; }
	
	public function getDependencies() : array
	{
		return [
			'Account', 'ActivationAlert', 'Address', 'Admin', 'Avatar',
			'Birthday', 'Category', 'Contact', 'Classic',
			'CountryRestrictions', 'CSS',
			'DoubleAccounts',
			'FontAtkinson', 'FontAwesome',
			'Invite', 'IP2Country',
			'Javascript', 'JQueryAutocomplete',
			'Licenses', 'Login',
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
		];
	}
	
	##############
	### Config ###
	##############
	public function getConfig() : array
	{
		return [
			GDT_UInt::make('free_stars_period')->min(0)->max(100)->initial('1'),
		];
	}
	public function cfgFreeStars() : int { return $this->getConfigValue('free_stars_period'); }
	
	
	################
	### Settings ###
	################
	public function getUserConfig() : array
	{
		return [
			GDT_Badge::make('coupon_kind')->tooltip('tt_coupon_kind')->icon('sun'),
			GDT_Badge::make('coupon_fast')->tooltip('tt_coupon_fast')->icon('star'),
			GDT_Badge::make('coupon_help')->tooltip('tt_coupon_help')->icon('bee'),
		    GDT_AccountType::make('kk_type')->notNull()->initial(GDT_AccountType::CUSTOMER),
			GDT_UInt::make('bonus_stars')->initial('0'),
		];
	}
	
	public function getUserSettings() : array
	{
		return [
		];
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
		$page->leftBar()->addFields(
			GDT_Link::make('link_kk_home')->icon('cc')->href($this->href('Welcome')),
			GDT_Link::make('link_kk_businesses')->href($this->href('Businesses')),
			GDT_Link::make('link_kk_employees')->href($this->href('Employees')),
			GDT_Link::make('link_kk_help')->href($this->href('Help')),
		);
		
		$user = GDO_User::current();
		if ($user->isUser())
		{
			if ($user->settingVar('Kassierercard', 'kk_type') === GDT_AccountType::CUSTOMER)
			{
				$page->rightBar()->addFields(
					GDT_Link::make('printed_coupons')->href($this->href('PrintedCoupons')),
					);
				
			}
			
			if ($user->settingVar('Kassierercard', 'kk_type') === GDT_AccountType::CASHIER)
			{
				$page->rightBar()->addFields(
					GDT_Link::make('enter_coupon')->href($this->href('EnterCoupon')),
					);
				
			}
			
			$page->rightBar()->addFields(
				GDT_Badge::make()->icon('sun')->tooltip('tt_coupon_kind')->label('coupon_kind')->var($user->settingVar('KassiererCard', 'coupon_kind')),
				GDT_Badge::make()->icon('star')->tooltip('tt_coupon_fast')->label('coupon_fast')->var($user->settingVar('KassiererCard', 'coupon_fast')),
				GDT_Badge::make()->icon('bee')->tooltip('tt_coupon_help')->label('coupon_help')->var($user->settingVar('KassiererCard', 'coupon_help')),
			);
		}
		
		$page->bottomBar()->addFields(
			GDT_Link::make('link_kk_partners')->href($this->href('Partners')),
		);
	}
	
	############
	### Hook ###
	############
	public function hookCreateCardUserProfile(GDT_Card $card)
	{
		$user = $card->gdo->getUser();
		$linkPM = GDT_Link::make()->href($this->href('SendCoupons', '&user='.$user->renderUserName()))->label('btn_send_coupons');
		$card->actions()->addField($linkPM);
	}
	
	public function hookRegisterForm(GDT_Form $form)
	{
	    $type = GDT_AccountType::make('kk_type')->notNull()->tooltip('tt_kk_type')->icon('info');
	    $form->addFieldAfterNamed($type, 'user_name');
	    $form->text('kk_info_register');
	}
	
	public function hookOnRegister(GDT_Form $form, GDO_UserActivation $activation)
	{
// 		$user = GDO_User::current();
		$type = $form->getFormVar('kk_type');
		$data = $activation->gdoValue('ua_data');
		$data['kk_type'] = $type;
		$activation->setValue('ua_data', $data);
	}
	
	public function hookUserActivated(GDO_User $user, GDO_UserActivation $activation = null)
	{
		if ($activation)
		{
			$data = $activation->gdoValue('ua_data');
			if (@$data['kk_type'])
			{
				$this->saveUserSetting($user, 'kk_type', $data['kk_type']);
				GDO_UserPermission::grant($user, $data['kk_type']);
			}
		}
	}
	
	############
	### Bars ###
	############
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
	
	
}
