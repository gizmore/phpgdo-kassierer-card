<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\KassiererCard\GDT_Business;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\KC_Business;
use GDO\KassiererCard\KC_Working;
use GDO\User\GDO_User;
use GDO\Date\GDT_Date;
use GDO\Date\Time;

/**
 * Set yourself to be working at a business.
 * 
 * @author gizmore
 */
final class WorkingThere extends MethodForm
{
	public function getPermission() : ?string { return 'kk_cashier'; }
	
	public function gdoParameters() : array
	{
		return [
			GDT_Business::make('biz')->notNull(),
		];
	}
	
	public function createForm(GDT_Form $form): void
	{
		$user = GDO_User::current();
		$working = $this->getBusiness()->isWorkingHere($user);
		$form->addFields(
			$this->gdoParameter('biz'),
			GDT_Date::make('from'),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(
			GDT_Submit::make('btn_working_there')->disabled($working)->icon('construction')->onclick([$this, 'onStartedWork']),
			GDT_Submit::make('btn_stopped_there')->enabled($working)->icon('error')->onclick([$this, 'onStoppedWork']),
		);
	}
	
	private function getBusiness() : KC_Business
	{
		return $this->gdoParameterValue('biz');
	}

	public function onStartedWork(): void
	{
		$biz = $this->getBusiness();
		$user = GDO_User::current();
		$dateFrom = $this->gdoParameterVar('from');
		KC_Working::stoppedWorking($user);
		KC_Working::startedWorking($user, $biz, $dateFrom);
		$args = [html($biz->renderName()), Time::displayDate($dateFrom, 'day')];
		$this->message('msg_kk_started_work', $args);
	}
	
	public function onStoppedWork(): void
	{
		$biz = $this->getBusiness();
		$user = GDO_User::current();
		KC_Working::stoppedWorking($user);
		$args = [html($biz->renderName())];
		$this->message('msg_kk_stopped_work', $args);
	}
	
}
