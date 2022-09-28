<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\GDT_Coupon;
use GDO\Form\GDT_Validator;

final class PrintCoupon extends MethodForm
{
// 	public function gdoParameters() : array
// 	{
// 		return [
// 			,
// 		];
// 	}
	
	public function createForm(GDT_Form $form): void
	{
		$coupon = GDT_Coupon::make('id')->notNull()->onlyOwnCreated();
		$form->addFields(
			$coupon,
// 			GDT_Validator::make()->validator($form, $coupon, [$this, 'validateOw']),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make());
	}


	
}
