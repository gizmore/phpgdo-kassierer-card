<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\KassiererCard\GDT_Offer;
use GDO\User\GDT_User;

final class PartnerRedeemOffer extends MethodForm
{
	public function getPermission() : ?string { return 'kk_company'; }
	
	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_Offer::make('offer')->fromMe()->notNull(),
			GDT_User::make('user')->withPermission('kk_customer,kk_cashier'),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(GDT_Submit::make());
	}

}
