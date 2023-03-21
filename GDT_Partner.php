<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_ObjectSelect;

final class GDT_Partner extends GDT_ObjectSelect
{

	protected function __construct()
	{
		parent::__construct();
		$this->table(KC_Partner::table());
	}

}
