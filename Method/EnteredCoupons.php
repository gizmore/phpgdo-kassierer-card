<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\KC_CouponEntered;

final class EnteredCoupons extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_CouponEntered::table();
	}


	
}
