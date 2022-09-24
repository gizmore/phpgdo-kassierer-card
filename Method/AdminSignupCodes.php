<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryTable;
use GDO\KassiererCard\KC_SignupCode;
use GDO\KassiererCard\MethodKCAdmin;

final class AdminSignupCodes extends MethodQueryTable
{
	use MethodKCAdmin;
	
	public function gdoTable()
	{
		return KC_SignupCode::table();
	}
	
}
