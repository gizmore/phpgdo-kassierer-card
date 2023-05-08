<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDT;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\KassiererCard\GDT_Offer;
use GDO\KassiererCard\KC_Offer;
use GDO\UI\GDT_Link;

final class RedeemOffer extends MethodForm
{

	public function getMethodTitle(): string
	{
		return t('redeem_offer');
	}

	protected function createForm(GDT_Form $form): void
	{
		$this->setupInfoText($form);
		$form->addFields(
			GDT_Offer::make('id')->notNull()->affordable()->emptyLabel('please_choose'),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(
			GDT_Submit::make(),
		);
	}

	public function setupInfoText(GDT_Form $form)
	{
		$offers = GDT_Link::make('all_offers')->href(href('KassiererCard', 'Offers'))->render();
		$form->text('kk_info_redeem_offer', [$offers]);
	}

	public function formValidated(GDT_Form $form): GDT
	{
		$offer = $this->getOffer();
		$append = "&offer={$offer->getID()}";
		$href = href('KassiererCard', 'RedeemOfferNow', $append);
		return $this->redirectMessage('msg_redeem_started', null, $href);
	}

	public function getOffer(): KC_Offer
	{
		return $this->gdoParameterValue('id');
	}

}
