<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryTable;
use GDO\KassiererCard\MethodKCAdmin;
use GDO\UI\GDT_DeleteButton;
use GDO\UI\GDT_Button;
use GDO\Util\Arrays;
use GDO\KassiererCard\KC_Coupon;

/**
 * Admin overview of KC Signup Codes.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class AdminSignupCodes extends MethodQueryTable
{
	use MethodKCAdmin;
	
	public function gdoTable()
	{
		return KC_Coupon::table();
	}
	
	public function gdoHeaders() : array
	{
		return Arrays::allExcept(array_merge([
				GDT_DeleteButton::make('delete'),
			],
			parent::gdoHeaders(), [
				GDT_Button::make('print')->label('print')->icon('print'),
			],
			), 'kc_invitation','kc_printed');
	}
	
}
