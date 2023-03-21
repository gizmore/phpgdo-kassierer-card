<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\KassiererCard\KC_Business;
use GDO\UI\MethodCard;

final class Business extends MethodCard
{

	public function gdoTable(): GDO
	{
		return KC_Business::table();
	}

}
