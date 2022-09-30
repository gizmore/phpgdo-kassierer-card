<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\UI\MethodCard;
use GDO\KassiererCard\KC_Partner;

final class Company extends MethodCard
{
	public function gdoTable(): GDO
	{
		return KC_Partner::table();
	}
	
}
