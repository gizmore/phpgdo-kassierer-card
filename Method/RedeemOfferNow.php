<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\KassiererCard\GDT_Offer;
use GDO\KassiererCard\KC_Offer;
use GDO\QRCode\GDT_QRCode;
use GDO\UI\GDT_Redirect;
use GDO\User\GDO_User;

final class RedeemOfferNow extends MethodForm
{

	public function isSidebarEnabled(): bool
	{
		if (
			($this->pressedButton === 'btn_qrcode') &&
			($this->validated)
		)
		{
			return false;
		}
		return true;
	}

	public function getMethodTitle(): string
	{
		return t('redeem_offer');
	}

	public function gdoParameters(): array
	{
		return [
			GDT_Offer::make('offer')->notNull()->affordable(),
		];
	}

	public function createForm(GDT_Form $form): void
	{
		$offer = $this->getOffer();
		$partner = $offer->getPartner();
		$form->text('kk_info_redeem_offer_now', [$partner->linkPartner()->render()]);
		$form->addFields(
			$partner->getCard(),
			$offer->getCard(),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(
			GDT_Submit::make('btn_qrcode')->onclick([$this, 'redeemQRCode']),
			GDT_Submit::make('btn_ok')->onclick([$this, 'redeemOKButton']),
			GDT_Submit::make('btn_abort')->onclick([$this, 'redeemAbort']),
		);
	}

	public function getOffer(): KC_Offer
	{
		return $this->gdoParameterValue('offer');
	}

	public function redeemQRCode(): GDT_QRCode
	{
		$user = GDO_User::current();
		$offer = $this->getOffer();
		return GDT_QRCode::make()
			->var($offer->urlRedeem($user));
	}

	public function redeemOKButton()
	{
		$offer = $this->getOffer();
		return GDT_Redirect::to(href('KassiererCard', 'RedeemOfferOk', "&offer={$offer->getID()}"));
	}

	public function redeemAbort()
	{
		return $this->redirectMessage('msg_redeem aborted')
			->href(href('KassiererCard', 'Offers'));
	}

}
