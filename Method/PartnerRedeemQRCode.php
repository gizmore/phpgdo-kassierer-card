<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\User\GDT_User;
use GDO\KassiererCard\GDT_Offer;
use GDO\Core\GDT_Token;
use GDO\KassiererCard\KC_Offer;
use GDO\User\GDO_User;

/**
 * Redeem an offer by scanning an QR code.
 * 
 * @author gizmore
 * @since 7.0.1
 */
final class PartnerRedeemQRCode extends MethodForm
{
	public function isUserRequired(): bool
	{
		return false;
	}
	
	public function gdoParameters(): array
	{
		return [
			GDT_User::make('user')->notNull(),
			GDT_Offer::make('offer')->notNull(),
		];
	}
	
	public function getUser(): GDO_User
	{
		return $this->gdoParameterValue('user');
	}
	
	public function getOffer(): KC_Offer
	{
		return $this->gdoParameterValue('offer');
	}
	
	public function createForm(GDT_Form $form): void
	{
		$form->text('kk_info_redeem_qr');
		$form->addFields(
			GDT_Token::make('token')->notNull(),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(GDT_Submit::make());
	}
	
}
