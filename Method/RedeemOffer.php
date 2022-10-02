<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\GDT_Offer;

final class RedeemOffer extends MethodForm
{
	public function getMethodTitle() : string
	{
		return t('redeem_coupon');
	}
	
	public function createForm(GDT_Form $form) : void
	{
		$this->setupInfoText($form);
		$form->addFields(
			GDT_Offer::make('id')->notNull()->writeable(false),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(
			GDT_Submit::make(),
		);
	}

	public function setupInfoText(GDT_Form $form)
	{
		$form->text('kk_info_redeem_offer');
	}
	
	public function formValidated(GDT_Form $form)
	{
		
	}

}
