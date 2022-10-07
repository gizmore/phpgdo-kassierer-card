<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\KassiererCard\MethodKCAdmin;
use GDO\User\GDT_User;
use GDO\KassiererCard\GDT_CouponStars;
use GDO\Form\GDT_AntiCSRF;
use GDO\User\GDO_User;
use GDO\Mail\Mail;
use GDO\Core\GDT_String;

/**
 * A manager method to grant stars to anyone.
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 7.0.1
 */
final class AdminGrantStars extends MethodForm
{
	use MethodKCAdmin;
	
	public function getMethodTitle() : string
	{
		return t('grant_stars');
	}
	
	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_String::make('reason'),
			GDT_User::make('user')->notNull(),
			GDT_CouponStars::make('stars')->min(1)->max(1000)->notNull(),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(GDT_Submit::make());
	}
	
	public function getUser() : GDO_User
	{
		return $this->gdoParameterValue('user');
	}
	
	public function formValidated(GDT_Form $form)
	{
		$admn = GDO_User::current();
		$user = $this->getUser();
		$stars = $this->gdoParameterValue('stars');
		$reason = $this->gdoParameterVar('reason');
		$admn->increaseSetting('KassiererCard', 'stars_created', $stars);
		$user->increaseSetting('KassiererCard', 'stars_available', $stars);
		$user->increaseSetting('KassiererCard', 'stars_purchased', $stars);
		$this->sendMail($admn, $user, $stars, $reason);
		return $this->message('msg_stars_granted', [$stars, $user->renderProfileLink()]);
	}
	
	private function sendMail(GDO_User $admin, GDO_User $user, int $stars, string $reason=null) : void
	{
		$mail = Mail::botMail();
		$mail->setSubject(tusr($user, 'mail_subj_kk_grant_stars', [sitename(), $stars]));
		$args = [
			$user->renderUserName(),
			$admin->renderUserName(),
			$stars,
			sitename(),
			html($reason),
		];
		$mail->setBody(tusr($user, 'mail_body_kk_grant_stars', $args));
		$mail->sendToUser($user);
	}
	
}
