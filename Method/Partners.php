<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Partner;

final class Partners extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Partner::table();
	}

}
