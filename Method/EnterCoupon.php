<?php
declare(strict_types=1);
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO_ArgError;
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
 * @version 7.0.3
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

	/**
	 * @throws GDO_ArgError
	 */
	public function formValidated(GDT_Form $form): GDT
	{
		$user = GDO_User::current();
		$coupon = $this->getCoupon();
		$coupon->entered($user);
		return $this->redirectMessage('msg_entered_stars', [$coupon->getStars()], $this->href());
	}

	/**
	 * @throws GDO_ArgError
	 */
	public function getCoupon(): ?KC_Coupon
	{
		$token = $this->getToken();
		return KC_Coupon::getByToken($token);
	}

	/**
	 * @throws GDO_ArgError
	 */
	public function getToken(): string
	{
		return $this->gdoParameterVar('token');
	}

	/**
	 * @throws GDO_ArgError
	 */
	public function validateToken(GDT_Form $form, GDT_CouponToken $field, $value): bool
	{
//		$token = trim(strtoupper($value));
//		$token = preg_replace('/[^A-Z0-9]/iD', '', $token);
		if (!($coupon = $this->getCoupon()))
		{
			return $field->error('err_kk_coupon_unknown');
		}
		if ($coupon->isEntered())
		{
			return $field->error('err_kk_coupon_used');
		}
//		if ()
//		$coupon->getToken()
		return true;
	}

}
