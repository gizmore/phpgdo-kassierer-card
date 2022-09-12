<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\GDT_Coupon;

final class PrintCoupon extends MethodForm
{
	public function gdoParameters() : array
	{
		return [
			GDT_Coupon::make('token')->notNull(),
		];
	}
	
	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make());
	}


	
}
