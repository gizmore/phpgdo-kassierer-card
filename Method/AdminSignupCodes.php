<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\MethodKCAdmin;
use GDO\Table\MethodQueryTable;
use GDO\UI\GDT_Button;
use GDO\UI\GDT_DeleteButton;
use GDO\Util\Arrays;

/**
 * Admin overview of KC Signup Codes.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class AdminSignupCodes extends MethodQueryTable
{

	use MethodKCAdmin;

	public function gdoTable(): GDO
	{
		return KC_Coupon::table();
	}

	public function gdoHeaders(): array
	{
		return Arrays::allExcept(array_merge([
			GDT_DeleteButton::make('delete'),
		],
			parent::gdoHeaders(), [
				GDT_Button::make('print')->label('print')->icon('print'),
			],
		), 'kc_invitation', 'kc_printed');
	}

}
