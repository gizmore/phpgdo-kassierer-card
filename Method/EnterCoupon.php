<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDT;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_Validator;
use GDO\Form\MethodForm;
use GDO\KassiererCard\GDT_CouponToken;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\User\GDO_User;

/**
 * Method for cashiers to enter coupons.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class EnterCoupon extends MethodForm
{

	public function getPermission(): ?string { return 'kk_cashier'; }

	public function getMethodTitle(): string
	{
		return t('enter_coupon');
	}

	public function beforeExecute(): void
	{
		Module_KassiererCard::instance()->addCashierBar();

		if (!GDO_User::current()->isAuthenticated())
		{
			$this->redirectError('msg_kk_enter_auth', null, $_SESSION['REQUEST_URI']);
		}
	}

	protected function createForm(GDT_Form $form): void
	{
		$token = GDT_CouponToken::make('token');
		$form->addFields(
			$token,
			GDT_Validator::make()->validator($form, $token, [$this, 'validateToken']),
		);
		$form->actions()->addField(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form): GDT
	{
		$user = GDO_User::current();
		$coupon = $this->getCoupon();
		$coupon->entered($user);
		return $this->redirectMessage('msg_entered_stars', [$coupon->getStars()], $this->href());
	}

	public function getCoupon(): ?KC_Coupon
	{
		$token = $this->getToken();
		return KC_Coupon::getByToken($token);
	}

	public function getToken(): string
	{
		return $this->gdoParameterVar('token');
	}

	public function validateToken(GDT_Form $form, GDT_CouponToken $field, $value)
	{
		$token = trim(strtoupper($value));
		$token = preg_replace('/[^A-Z0-9]/iD', '', $token);
		if (!($coupon = $this->getCoupon()))
		{
			return $field->error('err_kk_coupon_unknown');
		}
		if ($coupon->isEntered())
		{
			return $field->error('err_kk_coupon_used');
		}
		return true;
	}

}
