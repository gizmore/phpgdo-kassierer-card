<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\User\GDO_User;
use GDO\User\GDT_User;
use GDO\Mail\Mail;

/**
 * Offer redeemed event. Send mails, add entry.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class KC_OfferRedeemed extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('or_id'),
			GDT_User::make('or_user')->notNull(),
			GDT_Offer::make('or_offer')->notNull(),
			GDT_CreatedAt::make('or_created'),
			GDT_CreatedBy::make('or_creator'),
		];
	}
	
	public function getUser(): GDO_User
	{
		return $this->gdoValue('or_user');
	}
	
	public function getOffer(): KC_Offer
	{
		return $this->gdoValue('or_offer');
	}
	
	##############
	### Static ###
	##############
	public static function onRedeemed(GDO_User $user, KC_Offer $offer) : bool
	{
		$partner = $offer->getPartner();
		$owner = $partner->getUser();

		# Entry
		self::blank([
			'or_user' => $user->getID(),
			'or_offer' => $offer->getID(),
		])->insert();
		
		# Stats
		$kk = Module_KassiererCard::instance();
		$kkn = $kk->getModuleName();
		$kk->increaseConfigVar('offers_redeemed');
		$kk->increaseConfigVar('stars_redeemed', $offer->getRequiredStars());
		$kk->increaseConfigVar('euros_earned', $offer->getWorth());
		$owner->increaseSetting($kkn, 'offers_fullfilled');
		$owner->increaseSetting($kkn, 'euros_fullfilled', $offer->getWorth());
		$user->increaseSetting($kkn, 'offers_redeemed');
		$user->increaseSetting($kkn, 'stars_redeemed', $offer->getRequiredStars());
		$user->increaseSetting($kkn, 'stars_available', -$offer->getRequiredStars());
		
		# Mails
		self::sendRedeemMails($user, $offer);
		
		return true;
	}
	
	private static function sendRedeemMails(GDO_User $user, KC_Offer $offer): void
	{
		self::sendRedeemMailsToStaff($user, $offer);
		self::sendRedeemMailToUser($user, $offer);
		self::sendRedeemMailToPartner($user, $offer);
	}
	
	private static function sendRedeemMailsToStaff(GDO_User $user, KC_Offer $offer): void
	{
		foreach (GDO_User::staff() as $staff)
		{
			self::sendRedeemMailToStaff($staff, $user, $offer);
		}
	}
	
	private static function sendRedeemMailToStaff(GDO_User $staff, GDO_User $user, KC_Offer $offer): void
	{
		$mail = Mail::botMail();
		$mail->setSubject(tusr($staff, 'mailsubj_redeemed_staff', [sitename()]));
		$args = [
			$staff->renderUserName(),
			$user->renderUserName(),
			$offer->renderName(),
			$offer->renderTitle(),
			$offer->queryNumRedeemedTotal(),
			$offer->getTotalOffers(),
			sitename(),
		];
		$mail->setBody(tusr($staff, 'mailbody_redeemed_staff', $args));
		$mail->sendToUser($staff);
	}
	
	private static function sendRedeemMailToUser(GDO_User $user, KC_Offer $offer): void
	{
		$mail = Mail::botMail();
		$mail->setSubject(tusr($user, 'mailsubj_redeemed_user', [sitename()]));
		$args = [
			$user->renderUserName(),
			$offer->getRequiredStars(),
			$offer->renderName(),
			$offer->renderTitle(),
			KC_Util::numStarsAvailable($user),
			sitename(),
		];
		$mail->setBody(tusr($user, 'mailbody_redeemed_user', $args));
		$mail->sendToUser($user);
	}
	
	private static function sendRedeemMailToPartner(GDO_User $user, KC_Offer $offer): void
	{
		$partner = $offer->getPartner();
		$owner = $partner->getUser();
		$mail = Mail::botMail();
		$mail->setSubject(tusr($user, 'mailsubj_redeemed_partner', [sitename()]));
		$args = [
			$owner->renderUserName(),
			$user->renderUserName(),
			$offer->renderName(),
			$offer->renderTitle(),
			$offer->queryNumRedeemedTotal(),
			$offer->getTotalOffers(),
			sitename(),
		];
		$mail->setBody(tusr($user, 'mailbody_redeemed_partner', $args));
		$mail->sendToUser($user);
	}
	
	
}
