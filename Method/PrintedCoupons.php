<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\DB\Query;
use GDO\User\GDO_User;

/**
 * Customer method.
 * Show all your printed coupons.
 * Auto prints coupons for today.
 * Show print button.
 * 
 * @author gizmore
 *
 */
final class PrintedCoupons extends MethodQueryList
{
	public function getPermission() : ?string
	{
		return 'kk_customer';
	}
	
	public function gdoTable()
	{
		return KC_Coupon::table();
	}

	public function beforeExecute() : void
	{
		Module_KassiererCard::instance()->addCustomerBar();
	}
	
	public function getQuery() : Query
	{
		$uid = GDO_User::current()->getID();
		return parent::getQuery()->where('kc_creator='.$uid);
	}

// 	public function execute()
// 	{
// 		$result = GDT_Tuple::make();
// 		$result->addField(Module_KassiererCard::get$this->getC)
// 		$result->addField(parent::execute());
// 		return $result;
// 	}
	
}
