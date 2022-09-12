<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;

final class PrintCoupons extends MethodForm
{
	public function beforeExecute() : void
	{
		Module_KassiererCard::instance()->addCustomerBar();
	}
	
	public function createForm(GDT_Form $form): void
	{
		$table = KC_Coupon::table();
		$form->addField($table->gdoColumn('coup_stars'));
		$form->addField($table->gdoColumn('coup_type'));
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addField(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form)
	{
		$vars = $form->getFormVars();
		KC_Coupon::blank($vars)->insert();
		return $this->redirectMessage('msg_coupon_created', null, href('KassiererCard', 'PrintedCoupons'));
	}
	
}
