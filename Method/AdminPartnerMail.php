<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\UI\GDT_Message;
use GDO\UI\GDT_Title;

/**
 * Send a mail to all partners.
 *
 * @author gizmore
 */
final class AdminPartnerMail extends MethodForm
{

	protected function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_Title::make('subject'),
			GDT_Message::make('body'),
		);
		$form->actions()->addField(GDT_Submit::make());
	}


}
