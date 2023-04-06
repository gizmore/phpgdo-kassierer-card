<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_Response;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\KassiererCard\GDT_Employee;
use GDO\User\GDT_User;

/**
 * Send coupons to an employee.
 *
 * @author gizmore
 */
final class SendCoupons extends MethodForm
{

	public function getMethodTitle(): string
	{
		return t('btn_send_coupons');
	}

	public function getMethodDescription(): string
	{
		return t('md_kassierercard_sendcoupons');
	}

	public function gdoParameters(): array
	{
		return [
			GDT_Employee::make('user'),
		];
	}

	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_User::make('user')->notNull(),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(
			GDT_Submit::make()->label('btn_send_coupons'));
	}

	public function formValidated(GDT_Form $form): GDT
	{
		return GDT_Response::make();
	}

}
