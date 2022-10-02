<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\UI\MethodCard;
use GDO\KassiererCard\KC_Business;

final class Business extends MethodCard
{
	public function gdoTable(): GDO
	{
		return KC_Business::table();
	}

}
