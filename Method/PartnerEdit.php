<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\KassiererCard\KC_Partner;
use GDO\User\GDO_User;
use GDO\Form\GDT_Submit;

/**
 * Partners can edit their web page.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class PartnerEdit extends MethodForm
{
	public function getPartner(): KC_Partner
	{
		$user = GDO_User::current();
		return KC_Partner::getFor($user);
	}
	
	public function createForm(GDT_Form $form): void
	{
		$table = KC_Partner::table();
		$hrefAccount = href('Account', 'AllSettings');
		$hrefContact = href('Contact', 'Form');
		$form->text('kk_info_partner_edit', [sitename(), $hrefAccount, $hrefContact]);
		$form->addFields(...$table->gdoColumnsOnly(
			'p_url', 'p_description', 'p_logo', 'p_website_content'));
		$form->actions()->addFields(GDT_Submit::make());
	}
	
}
