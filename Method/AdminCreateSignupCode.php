<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\MethodKCAdmin;
use GDO\Core\GDT_String;
use GDO\Form\GDT_AntiCSRF;
use GDO\KassiererCard\KC_SignupCode;

final class AdminCreateSignupCode extends MethodForm
{
	use MethodKCAdmin;
	
	public function createForm(GDT_Form $form) : void
	{
		$form->addFields(
			GDT_String::make('token')->notNull(),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make());
	}
	
	public function formValidated(GDT_Form $form)
	{
		KC_SignupCode::blank([
			'sc_token' => $form->getFormVar('token'),
		])->insert();
		$this->message('msg_signup_code_created');
	}

}
