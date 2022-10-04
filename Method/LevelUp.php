<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\GDT_CouponStars;
use GDO\Core\GDT_Enum;
use GDO\Form\GDT_AntiCSRF;

/**
 * Convert KassiererCard.org stars into user_level or GDOv7-Credits.
 * 
 * @author gizmore
 *
 */
final class LevelUp extends MethodForm
{
	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_CouponStars::make('stars')->notNull()->min(1),
			GDT_Enum::make('conversion_type')->notNull()->emptyLabel('please_choose'),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(GDT_Submit::make());
	}
	
	public function formValidated(GDT_Form $form)
	{
	}
	
}
