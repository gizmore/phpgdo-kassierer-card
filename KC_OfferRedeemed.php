<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\User\GDO_User;
use GDO\User\GDT_User;

final class KC_OfferRedeemed extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('or_id'),
			GDT_User::make('or_user')->notNull(),
			GDT_Offer::make('or_offer'),
			GDT_CreatedAt::make('or_created'),
			GDT_CreatedBy::make('or_creator'),
		];
	}
	
	##############
	### Static ###
	##############
	public static function onRedeemed(GDO_User $user, KC_Offer $offer) : bool
	{
		self::blank([
			'or_user' => $user->getID(),
			'or_offer' => $offer->getID(),
		])->insert();
		$module = Module_KassiererCard::instance();
		$module->increaseConfigVar('offers_redeemed');
		$module->increaseConfigVar('euros_generated', $offer->getWorth());
		return true;
	}
	
}
