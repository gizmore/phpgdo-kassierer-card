<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\KassiererCard\KC_BusinessCard;

final class CompanyCreateCard extends MethodForm
{
	public function createForm(GDT_Form $form) : void
	{
		$table = KC_BusinessCard::table();
		$form->addFields(
			$table->gdoColumn('bc_name'),
			$table->gdoColumn('bc_front'),
			$table->gdoColumn('bc_back'),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form)
	{
		
	}
	
	
}
