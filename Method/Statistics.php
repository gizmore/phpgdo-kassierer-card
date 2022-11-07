<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\Method;
use GDO\UI\GDT_Card;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\Core\GDT;

/**
 * Show The KassiererCard.org project statistics.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class Statistics extends Method
{
	public function execute()
	{
		return $this->getCard();
	}

	public function getCard() : GDT_Card
	{
		$card = GDT_Card::make('kk_statistics');
		$card->titleRaw(sitename() . t('statistics'));
		$card->addField($this->statsField('coupons_created'));
		$card->addField($this->statsField('coupons_printed'));
		$card->addField($this->statsField('coupons_entered'));
		$card->addField($this->statsField('stars_created'));
		$card->addField($this->statsField('diamonds_earned'));
		$card->addField($this->statsField('diamonds_redeemed'));
		$card->addField($this->statsField('offers_created'));
		$card->addField($this->statsField('offers_redeemed'));
		$card->addField($this->statsField('euros_invested'));
		$card->addField($this->statsField('euros_earned'));
		return $card;
	}
	
	private static function statsField(string $key) : GDT
	{
		return Module_KassiererCard::instance()->getConfigColumn($key);
	}
	
	public function getMethodTitle(): string
	{
		return t('statistics');
	}
	
}
