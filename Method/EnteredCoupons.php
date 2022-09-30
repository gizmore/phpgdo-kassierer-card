<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Coupon;
use GDO\DB\Query;
use GDO\User\GDO_User;

/**
 * List your entered coupons
 * @author gizmore
 *
 */
final class EnteredCoupons extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Coupon::table();
	}
	
	public function getDefaultOrder() : ?string
	{
		return 'kc_entered DESC';
	}

	public function getQuery() : Query
	{
		$user = GDO_User::current();
		return parent::getQuery()->where("kc_enterer={$user->getID()}");
	}
	
	public function gdoHeaders() : array
	{
		$table = KC_Coupon::table();
		return [
			$table->gdoColumn('kc_entered'),
			$table->gdoColumn('kc_stars'),
			$table->gdoColumn('kc_token'),
			$table->gdoColumn('kc_creator'),
		];
	}

}
