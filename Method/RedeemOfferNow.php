<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\GDT_Offer;
use GDO\KassiererCard\KC_Offer;

final class RedeemOfferNow extends MethodForm
{
	public function getMethodTitle() : string
	{
		return t('redeem_offer');
	}
	
	public function gdoParameters() : array
	{
		return [
			GDT_Offer::make('offer')->notNull()->affordable(),
		];
	}
	
	public function getOffer() : KC_Offer
	{
		return $this->gdoParameterValue('offer');
	}
	
	public function createForm(GDT_Form $form) : void
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
			GDT_Submit::make('btn_abort')->onclick([$this, 'redeenAbort']),
		);
	}
	
	public function redeemQRCode()
	{
		
	}
	
	public function redeemOKButton()
	{
		
	}
	
	public function redeemAbort()
	{
		$this->redirectMessage('msg_redeem aborted');
	}
	
}
