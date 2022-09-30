<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_EnumNoI18n;

final class GDT_CouponType extends GDT_EnumNoI18n
{
	protected function __construct()
	{
		parent::__construct();
		$this->enumValues('coupon', 'cashier', 'company', 'customer');
		$this->notNull();
	}
	
}
