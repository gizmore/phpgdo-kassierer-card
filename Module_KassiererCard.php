<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO_Module;

final class Module_KassiererCard extends GDO_Module
{
	public int $priority = 100;
	
	public function getTheme() : ?string { return 'kkorg'; }
	
	public function getDependencies() : array
	{
		return [
			'Classic', 'JQueryAutocomplete', 'Javascript', 'CSS',
			'QRCode', 'Account', 'Admin', 'Login',
			'Register', 'Recovery',
			'PM', 'Contact', 'Avatar',
			'ActivationAlert', 'Invite', 'Birthday',
			'PaymentCredits', 'PaymentPaypal',
		];
	}
	
	public function onLoadLanguage() : void
	{
		$this->loadLanguage('lang/kassierercard');
	}
	
	public function getConfig() : array
	{
		return [
			
		];
	}
	
}
