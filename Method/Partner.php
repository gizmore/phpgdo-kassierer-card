<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\UI\GDT_Card;
use GDO\UI\GDT_Link;
use GDO\UI\MethodCard;
use GDO\KassiererCard\KC_Partner;

final class Partner extends MethodCard
{
	public function gdoTable(): GDO
	{
		return KC_Partner::table();
	}
	
	public function getMethodTitle(): string
	{
		return  $this->getObject()->renderName();
	}
	
	protected function createCard(GDT_Card $card): void
	{
		/** @var KC_Partner $partner **/
		$partner = $card->gdo;
		$addr = $partner->getAddress();
		$card->titleRaw(GDT_Link::anchor($partner->hrefPartner(), $addr->getCompany()));
		$card->subtitle('kk_partner_estab', [
			$partner->getUser()->renderProfileLink(),
			$addr->gdoDisplay('address_est')
		]);
		$card->image($partner->gdoColumn('p_logo'));
	}
	
}
