<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\Form\MethodCrud;
use GDO\KassiererCard\KC_Partner;
use GDO\User\GDO_User;

final class CompanyCrud extends MethodCrud
{

	public function hrefList(): string
	{
		return href('KassiererCard', 'CompanyBusinesses');
	}

	public function canUpdate(GDO $gdo): bool
	{
		$user = GDO_User::current();
		if ($user->isStaff())
		{
			return true;
		}
		/** @var $business KC_Partner * */
		$business = $gdo;
		return $business->getUser() === $user;
	}

	public function gdoTable(): GDO
	{
		return KC_Partner::table();
	}

}
