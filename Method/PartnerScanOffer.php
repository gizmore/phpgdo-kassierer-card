<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_Token;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_Validator;
use GDO\Form\MethodForm;
use GDO\KassiererCard\GDT_Offer;
use GDO\KassiererCard\KC_Offer;
use GDO\KassiererCard\KC_Util;
use GDO\User\GDO_User;
use GDO\User\GDT_User;

/**
 * Partners can scan offer QRCode.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class PartnerScanOffer extends MethodForm
{

	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_User::make('user')->withPermission('kk_customer,kk_cashier')->notNull(),
			GDT_Offer::make('offer')->notNull(),
			GDT_Token::make('token')->notNull(),
		);
		$form->addField(GDT_Validator::make('validator')->validatorFor($form, 'token', [$this, 'validateToken']));
		$form->actions()->addFields(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form): GDT
	{
		$user = $this->getUser();
		$offer = $this->getOffer();
	}

	public function getUser(): GDO_User
	{
		return $this->gdoParameterValue('user');
	}

	public function getOffer(): KC_Offer
	{
		return $this->gdoParameterValue('offer');
	}

	public function validateToken(GDT_Form $form, GDT $field, $value)
	{
		$user = $this->getUser();
		$offer = $this->getOffer();
		$token = $this->getToken();
		$reason = '';
		if (!$offer->canAfford($user, $reason))
		{
			return $field->error('err_kk_customer_cannot_afford_offer', [$reason]);
		}
		$hashcode = KC_Util::hashcodeForRedeem($user, $offer);
		if ($hashcode !== $token)
		{
			return $field->error('err_kk_redeem_hashcode');
		}
		return true;
	}

}
