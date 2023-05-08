<?php
declare(strict_types=1);
namespace GDO\KassiererCard\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_UInt;
use GDO\Date\GDT_Date;
use GDO\Date\Time;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\KassiererCard\GDT_Business;
use GDO\KassiererCard\KC_Business;
use GDO\KassiererCard\KC_Working;
use GDO\User\GDO_User;

/**
 * Set yourself to be working at a business.
 *
 * @author gizmore
 */
final class WorkingThere extends MethodForm
{

	public function getPermission(): ?string { return 'kk_cashier'; }

	public function gdoParameters(): array
	{
		return [
			GDT_Business::make('biz')->notNull(),
		];
	}

	protected function createForm(GDT_Form $form): void
	{
		$user = GDO_User::current();
		$working = $this->getBusiness()->isWorkingHere($user);
		$form->addFields(
			$this->gdoParameter('biz'),
			GDT_Date::make('from'),
			GDT_UInt::make('hours')->min(4)->max(80),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(
			GDT_Submit::make('btn_working_there')->disabled($working)->icon('construction')->onclick([$this, 'onStartedWork']),
			GDT_Submit::make('btn_stopped_there')->enabled($working)->icon('error')->onclick([$this, 'onStoppedWork']),
		);
	}

	private function getBusiness(): KC_Business
	{
		return $this->gdoParameterValue('biz');
	}

	public function onStartedWork(): GDT
	{
		$biz = $this->getBusiness();
		$user = GDO_User::current();
		$dateFrom = $this->gdoParameterVar('from');
		$hours = $this->gdoParameterValue('hours');
		KC_Working::stoppedWorking($user);
		KC_Working::startedWorking($user, $biz, $dateFrom, $hours);
		$args = [html($biz->renderName()), Time::displayDate($dateFrom, 'day')];
		return $this->message('msg_kk_started_work', $args);
	}

	public function onStoppedWork(): GDT
	{
		$biz = $this->getBusiness();
		$user = GDO_User::current();
		KC_Working::stoppedWorking($user);
		$args = [html($biz->renderName())];
		return $this->message('msg_kk_stopped_work', $args);
	}

}
