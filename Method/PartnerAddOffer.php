<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\KassiererCard\KC_Offer;

/**
 * @author gizmore
 */
final class PartnerAddOffer extends MethodForm
{

	public function createForm(GDT_Form $form): void
	{
		$o = KC_Offer::table();
		$form->addFields(

			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make());
	}

}
