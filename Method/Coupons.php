<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\KassiererCard\KC_Coupon;
use GDO\Table\MethodQueryList;

final class Coupons extends MethodQueryList
{

	public function gdoTable(): GDO
	{
		return KC_Coupon::table();
	}

}
