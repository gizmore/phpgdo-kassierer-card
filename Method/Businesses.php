<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Business;

final class Businesses extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Business::table();
	}
	
}
