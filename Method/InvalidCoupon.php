<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\Method;

final class InvalidCoupon extends Method
{
	public function execute()
	{
		return print_r($_REQUEST, 1);
	}
	
}
