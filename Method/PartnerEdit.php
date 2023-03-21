<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\KassiererCard\KC_Partner;
use GDO\User\GDO_User;

/**
 * Partners can edit their web page.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class PartnerEdit extends MethodForm
{

	public function isTrivial(): bool
	{
		return false;
	}

	public function getPermission(): ?string
	{
		return 'kk_company';
	}

	public function createForm(GDT_Form $form): void
	{
		$table = KC_Partner::table();
		$hrefAccount = href('Account', 'AllSettings');
		$hrefContact = href('Contact', 'Form');
		$form->text('kk_info_partner_edit', [sitename(), $hrefAccount, $hrefContact]);
		$form->addFields(...$table->gdoColumnsOnly(
			'p_url', 'p_logo', 'p_description',
			'p_website_content'));
		$form->addField(GDT_AntiCSRF::make());
		$form->actions()->addFields(GDT_Submit::make());
		$form->initFromGDO($this->getPartner());
	}

	public function getPartner(): KC_Partner
	{
		$user = GDO_User::current();
		return KC_Partner::getForUser($user);
	}

	public function formValidated(GDT_Form $form)
	{
		$partner = $this->getPartner();
		$data = $form->getFormVars();
		$partner->saveVars($data);
		return parent::formValidated($form);
	}

}
