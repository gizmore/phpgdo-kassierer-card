<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Badge;
use GDO\UI\GDT_Page;
use GDO\UI\GDT_Link;

/**
 * KassiererCard.org - At least we try! 
 * 
 * @author gizmore
 * @since 7.0.1
 */
final class Module_KassiererCard extends GDO_Module
{
	public int $priority = 100;
	
	public function getTheme() : ?string { return 'kkorg'; }
	
	public function getDependencies() : array
	{
		return [
			'Classic', 'JQueryAutocomplete', 'Javascript', 'CSS',
			'QRCode', 'Account', 'Admin', 'Login', 'Address',
			'Register', 'Recovery', 'Maps', 'Category',
			'PM', 'Contact', 'Avatar', 'Licenses',
			'ActivationAlert', 'Invite', 'Birthday',
		];
	}
	
	public function getClasses() : array
	{
		return [
			KC_Business::class,
			KC_Working::class,
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
			GDT_Badge::make('coupon_kind')->initial('0'),
			GDT_Badge::make('coupon_fast')->initial('0'),
			GDT_Badge::make('coupon_help')->initial('0'),
		];
	}
	
	public function getUserSettings() : array
	{
		return [];
	}
	
	############
	### Hook ###
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
			GDT_Link::make('link_kk_home')->href($this->href('Welcome')),
			GDT_Link::make('link_kk_businesses')->href($this->href('Businesses')),
			GDT_Link::make('link_kk_employees')->href($this->href('Empolyees')),
			GDT_Link::make('link_kk_help')->href($this->href('Help')),
			
		);
	}
	
}
