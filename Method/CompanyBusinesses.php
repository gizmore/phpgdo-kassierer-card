<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\DB\Query;
use GDO\KassiererCard\KC_Business;
use GDO\KassiererCard\WithCompanyAccount;
use GDO\Table\MethodQueryList;
use GDO\User\GDO_User;

final class CompanyBusinesses extends MethodQueryList
{

	use WithCompanyAccount;

	public function gdoTable(): GDO
	{
		return KC_Business::table();
	}

	public function getQuery(): Query
	{
		$user = GDO_User::current();
		return parent::getQuery()->where("biz_owner={$user->getID()}");
	}

}
