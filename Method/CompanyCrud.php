<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\Form\MethodCrud;
use GDO\User\GDO_User;
use GDO\KassiererCard\KC_Partner;

final class CompanyCrud extends MethodCrud
{
	public function hrefList(): string
	{
		return href('KassiererCard', 'CompanyBusinesses');
	}

	public function canUpdate(GDO $gdo) : bool
	{
		/** @var $business KC_Partner **/
		$business = $gdo;
		$business->getOwner() === GDO_User::current();
	}
	
	public function gdoTable(): GDO
	{
		return KC_Partner::table();
	}
	
}
