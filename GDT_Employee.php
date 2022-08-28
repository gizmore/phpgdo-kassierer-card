<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Object;

final class GDT_Employee extends GDT_Object
{
	protected function __construct()
	{
		parent::__construct();
		$this->table(KC_Working::table());
	}
	
}
