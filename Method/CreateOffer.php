<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\KassiererCard\KC_Offer;

/**
 * Create an offer.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class CreateOffer extends MethodForm
{
	public function getMethodTitle() : string
	{
		return t('create_offer');
	}
	
	public function createForm(GDT_Form $form) : void
	{
		$table = KC_Offer::table();
		$form->text('info_create_offer');
		$form->addFields(
			...$table->gdoColumnsExcept('o_id', 'o_created', 'o_creator'),
		);
		$form->addFields(
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form)
	{
		
	}
	
}
