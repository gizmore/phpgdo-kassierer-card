<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Object;
use GDO\Core\GDT;

final class GDT_Coupon extends GDT_Object
{
	
	protected function __construct()
	{
		parent::__construct();
		$this->table(KC_Coupon::table());
	}
	
	
}
