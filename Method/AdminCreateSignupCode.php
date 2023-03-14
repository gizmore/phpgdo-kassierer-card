<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\MethodKCAdmin;
use GDO\Form\GDT_AntiCSRF;
use GDO\KassiererCard\GDT_CouponToken;
use GDO\KassiererCard\GDT_CouponType;
use GDO\KassiererCard\GDT_CouponStars;
use GDO\KassiererCard\KC_Coupon;

/**
 * Staff can create a special signup code for registration.
 * 
 * @author gizmore
 * @since 7.0.1
 */
final class AdminCreateSignupCode extends MethodForm
{
	use MethodKCAdmin;

	public function isTrivial(): bool
	{
		return false;
	}

	public function createForm(GDT_Form $form) : void
	{
		$table = KC_Coupon::table();
		$form->addFields(
			$table->gdoColumn('kc_info'),
			GDT_CouponToken::make('kc_token')->notNull()->initialRandomKey(),
			GDT_CouponType::make('kc_type')->notNull()->initial('kk_cashier'),
			GDT_CouponStars::make('kc_stars'),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make());
	}
	
	public function formValidated(GDT_Form $form)
	{
		$coupon = KC_Coupon::blank($form->getFormVars())->insert();
		return $this->redirectMessage('msg_signup_code_created', [
			$coupon->renderType(),
		], $this->href());
	}

}
