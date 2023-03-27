<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\KassiererCard\KC_Business;
use GDO\Table\MethodQueryList;

final class Businesses extends MethodQueryList
{

	public function gdoTable(): GDO
	{
		return KC_Business::table();
	}

}
