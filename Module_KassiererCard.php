<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Badge;
use GDO\UI\GDT_Page;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;
use GDO\UI\GDT_Card;

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
			'Classic', 'JQueryAutocomplete', 'Javascript', 'CSS',
			'QRCode', 'Account', 'Admin', 'Login', 'Address',
			'Register', 'Recovery', 'Maps', 'Category',
			'PM', 'Contact', 'Avatar', 'Licenses',
			'ActivationAlert', 'Invite', 'Birthday',
			'FontAwesome', 'Markdown', 'News',
			'Category', 'Maps',
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
			
		];
	}
	
	################
	### Settings ###
	################
	public function getUserConfig() : array
	{
		return [
			GDT_Badge::make('coupon_kind')->tooltip('tt_coupon_kind')->icon('user'),
			GDT_Badge::make('coupon_fast')->tooltip('tt_coupon_fast')->icon('user'),
			GDT_Badge::make('coupon_help')->tooltip('tt_coupon_help')->icon('user'),
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
			GDT_Link::make('link_kk_employees')->href($this->href('Empolyees')),
			GDT_Link::make('link_kk_help')->href($this->href('Help')),
		);
		
		$user = GDO_User::current();
		if ($user->isUser())
		{
			$page->rightBar()->addFields(
				GDT_Badge::make()->icon('user')->tooltip('tt_coupon_kind')->label('coupon_kind')->var($user->settingVar('KassiererCard', 'coupon_kind')),
				GDT_Badge::make()->icon('user')->tooltip('tt_coupon_fast')->label('coupon_fast')->var($user->settingVar('KassiererCard', 'coupon_fast')),
				GDT_Badge::make()->icon('user')->tooltip('tt_coupon_help')->label('coupon_help')->var($user->settingVar('KassiererCard', 'coupon_help')),
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
	
	
}
