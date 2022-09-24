<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Offer;

final class Offers extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Offer::table();
	}
	
}
