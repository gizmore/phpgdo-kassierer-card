<?php
namespace GDO\KassiererCard\Method;

use GDO\KassiererCard\KC_Coupon;
use GDO\Table\MethodQueryList;

final class Coupons extends MethodQueryList
{

	public function gdoTable()
	{
		return KC_Coupon::table();
	}

}
