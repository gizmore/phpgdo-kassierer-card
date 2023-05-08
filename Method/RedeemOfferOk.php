<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDT;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\KassiererCard\GDT_Offer;
use GDO\KassiererCard\KC_Offer;
use GDO\User\GDO_User;

final class RedeemOfferOk extends MethodForm
{

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

	protected function createForm(GDT_Form $form): void
	{
		$offer = $this->getOffer();
		$partner = $offer->getPartner();
		$form->text('kk_info_redeem_offer_ok', [$partner->linkPartner()->render()]);
		$form->addFields(
			$offer->getCard(),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(
			GDT_Submit::make(),
		);
	}

	public function getOffer(): KC_Offer
	{
		return $this->gdoParameterValue('offer');
	}

	public function formValidated(GDT_Form $form): GDT
	{
		$offer = $this->getOffer();
		$offer->onRedeem(GDO_User::current());
		$args = [
			html($offer->getPassphrase()),
		];
		$href = hrefDefault();
		return $this->redirectMessage('msg_offer_redeemed_ok', $args, $href);
	}

}
