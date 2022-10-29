<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryTable;
use GDO\User\GDO_User;
use GDO\DB\Query;

final class Customers extends MethodQueryTable
{
	public function gdoTable()
	{
		return GDO_User::table();
	}
	
	public function getQuery() : Query
	{
		$query = GDO_User::withPermissionQuery('kk_customer');
		$query->selectOnly('user_id,user_name,tcc.uset_var');
		$query->join('LEFT JOIN gdo_usersetting tcc ON uset_user=perm_user_id_t.user_id AND uset_name="coupons_created"');
		return $query;
	}
	
}
