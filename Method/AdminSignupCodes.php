<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryTable;
use GDO\KassiererCard\KC_SignupCode;
use GDO\KassiererCard\MethodKCAdmin;
use GDO\UI\GDT_DeleteButton;
use GDO\UI\GDT_Button;

final class AdminSignupCodes extends MethodQueryTable
{
	use MethodKCAdmin;
	
	public function gdoTable()
	{
		return KC_SignupCode::table();
	}
	
	public function gdoHeaders() : array
	{
		return array_merge([
				GDT_DeleteButton::make('kca_delete'),
			],
			parent::gdoHeaders(), [
				GDT_Button::make('kca_print')->label('print')->icon('print'),
			],
		);
	}
	
}
