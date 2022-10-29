<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\DB\Query;
use GDO\User\GDO_User;

/**
 * Show your created coupons that got entered by someone.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GrantedCoupons extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Coupon::table();
	}
	
	public function beforeExecute() : void
	{
		Module_KassiererCard::instance()->addCustomerBar();
	}
	
	public function getQuery(): Query
	{
		$uid = GDO_User::current()->getID();
		$query = parent::getQuery();
		$query->where("kc_creator={$uid}");
		$query->where("kc_entered IS NOT NULL");
		return $query;
	}

}
