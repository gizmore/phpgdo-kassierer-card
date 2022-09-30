<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\MethodKCAdmin;
use GDO\Form\GDT_AntiCSRF;
use GDO\KassiererCard\KC_SignupCode;
use GDO\KassiererCard\GDT_CouponToken;
use GDO\KassiererCard\GDT_CouponType;
use GDO\KassiererCard\GDT_CouponStars;

/**
 * Create a special signup code for register form.
 * 
 * @author gizmore
 * @since 7.0.1
 */
final class AdminCreateSignupCode extends MethodForm
{
	use MethodKCAdmin;
	
	public function createForm(GDT_Form $form) : void
	{
		$form->addFields(
			GDT_CouponToken::make('sc_token')->notNull()->initialRandomKey(),
			GDT_CouponType::make('sc_type')->notNull()->initial('kk_cashier'),
			GDT_CouponStars::make('sc_stars'),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make());
	}
	
	public function formValidated(GDT_Form $form)
	{
		$code = KC_SignupCode::blank($form->getFormVars())->insert();
		$code->createCouponForSignupCode();
		return $this->redirectMessage('msg_signup_code_created', [
			$this->gdoParameter('sc_type')->renderVar()
		], $this->href());
	}

}
