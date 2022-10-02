<?php
namespace GDO\KassiererCard;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Core\GDT_Token;
use GDO\User\GDT_User;
use GDO\User\GDO_User;

final class CompanyRedeemsOffer extends MethodForm
{
	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_Offer::make('offer'),
			GDT_User::make('receiver'),
			GDT_Token::make('token')->length(32)->initialNull()->notNull(),
		);
		$form->actions()->addFields(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form)
	{
		$offer = $form->getFormValue('offer');
		$user = $form->getFormValue('receiver');
		$token = $form->getFormVar('token');
	}
	
	public function redeemOffer(GDO_User $user, KC_Offer $offer) : bool
	{
		if ($offer->isOfferValid())
		{
			
		}
		return true;
	}
	
}
