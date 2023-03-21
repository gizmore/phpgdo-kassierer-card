<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\Form\GDT_Form;
use GDO\Form\MethodCrud;
use GDO\KassiererCard\KC_Business;
use GDO\UI\GDT_Link;

final class BusinessCrud extends MethodCrud
{

	public function hrefList(): string
	{
		return href('KassiererCard', 'Businesses');
	}

	public function gdoTable(): GDO
	{
		return KC_Business::table();
	}

	public function createForm(GDT_Form $form): void
	{
		$href = href('Address', 'Add');
		$link = GDT_Link::make('create_an_address')->href($href)->render();
		$form->text('kk_info_crud_business', [$link]);
		parent::createForm($form);
	}

}
