<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\Form\MethodCrud;
use GDO\KassiererCard\KC_Business;
use GDO\User\GDO_User;

final class CompanyCrud extends MethodCrud
{
	public function hrefList(): string
	{
		return href('KassiererCard', 'CompanyBusinesses');
	}

	public function canUpdate(GDO $gdo) : bool
	{
		/** @var $business KC_Business **/
		$business = $gdo;
		$business->getOwner() === GDO_User::current();
	}
	
	public function gdoTable(): GDO
	{
		return KC_Business::table();
	}

	
}
