<?php
namespace GDO\KassiererCard\Method;

use GDO\Form\GDT_Form;
use GDO\Form\MethodForm;
use GDO\Form\GDT_Submit;
use GDO\Form\GDT_AntiCSRF;
use GDO\KassiererCard\GDT_CouponStars;
use GDO\Mail\GDT_Email;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\KassiererCard\KC_Util;
use GDO\User\GDO_User;
use GDO\Language\GDT_Language;
use GDO\KassiererCard\KC_Coupon;
use GDO\KassiererCard\GDT_CouponType;
use GDO\KassiererCard\GDT_CouponToken;
use GDO\Mail\Mail;
use GDO\UI\GDT_Link;
use GDO\KassiererCard\KC_Offer;
use GDO\User\GDT_ProfileLink;

/**
 * Send invitations which might convert stars to diamonds.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class Invite extends MethodForm
{

	public function isTrivial(): bool
	{
		return false;
	}

	public function getMethodTitle(): string
	{
		return t('invite_users');
	}
	
	public function createForm(GDT_Form $form): void
	{
		$user = GDO_User::current();
		$module = Module_KassiererCard::instance();
		$starsPerInvite = $module->cfgStarsPerInvite();
		$starsAvailable = KC_Util::numStarsAvailable($user);
		$form->text('kk_info_invite_stars', [
			sitename(), $starsPerInvite, $starsAvailable]);
		$form->addFields(
			GDT_CouponStars::make('stars')->notNull()->initial('1')->min(0)->max($starsAvailable - $starsPerInvite),
			GDT_CouponType::make('type')->notNull()->noCoupon()->noCompany()->emptyLabel('kk_type'),
			GDT_CouponToken::make('token')->hidden()->initialRandomKey()->notNull(),
			GDT_Email::make('email')->notNull(),
			GDT_Language::make('language')->notNull()->initialCurrent(),
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addFields(GDT_Submit::make());
	}
	
	public function formValidated(GDT_Form $form)
	{
		$user = GDO_User::current();
		$stars = $form->getFormVar('stars');
		$email = $form->getFormVar('email');
		$lang = $form->getFormVar('language');
		$token = $form->getFormVar('token');
		$type = $form->getFormVar('type');
		return $this->sendInvitation($user, $email, $type, $stars, $lang, $token);
	}
	
	public function sendInvitation(GDO_User $user, string $email, string $type, int $stars, string $lang, string $token)
	{
		$module = Module_KassiererCard::instance();
		$starsPerInvite = $module->cfgStarsPerInvite();
		$starsTotal = $starsPerInvite + $stars;
		$user->increaseSetting('KassiererCard', 'stars_invited', $starsTotal);
		$user->increaseSetting('KassiererCard', 'stars_available', -$starsTotal);
		$module->increaseConfigVar('stars_invited', $starsTotal);
		# Insert coupon
		$coupon = $this->createCoupon($user, $type, $stars, $token);
		# Send mail
		$this->sendMail($user, $email, $lang, $coupon);
		return $this->message('msg_kk_sent_invitation', [
			$starsPerInvite,
			$email, 
			$stars,
		]);
	}
	
	private function createCoupon(GDO_User $user, string $type, int $stars, string $token): KC_Coupon
	{
		return KC_Coupon::blank([
			'kc_token' => $token,
			'kc_type' => $type,
			'kc_invitation' => '1',
			'kc_stars' => $stars,
			'kc_creator' => $user->getID(),
		])->insert();
	}
	
	private function sendMail(GDO_User $user, string $email, string $lang, KC_Coupon $coupon): void
	{
		$mail = Mail::botMail();
		$starsPerEuro = Module_KassiererCard::instance()->cfgStarsPerEuro();
		$mail->setSubject(tiso($lang, 'mailsubj_kk_invite', [sitename(), $coupon->renderType()]));
		$mail->setBody(tiso($lang, 'mailbody_kk_invite', [
			GDT_ProfileLink::make()->user($user)->nickname()->render(),
			$coupon->renderType(),
			GDT_Link::anchor($coupon->urlEnter(), sitename()),
			$starsPerEuro,
			html($user->getMail()),
			$coupon->getStars(),
			KC_Offer::getAvailableOffers(),
			GDT_Link::anchor($coupon->urlEnter(), sitename()),
		]));
		$mail->setReceiver($email);
		$mail->sendAsHTML(GDO_ADMIN_EMAIL);
	}
	
}
