<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Working;

final class Employees extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Working::table();
	}
	
}
