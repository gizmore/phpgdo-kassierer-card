<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Coupon;

final class Coupons extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Coupon::table();
	}
	
	
}
