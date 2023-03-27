<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDT;
use GDO\Core\GDT_UInt;
use GDO\Core\Method;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\LoC\LoC;
use GDO\UI\GDT_Card;
use GDO\UI\GDT_Paragraph;

/**
 * Show The KassiererCard.org project statistics.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class Statistics extends Method
{

	public function execute(): GDT
	{
		return $this->getCard();
	}

	public function getCard(): GDT_Card
	{
		LoC::init();
		$loc = LoC::gdo();
		$card = GDT_Card::make('kk_statistics');
		$card->titleRaw(sitename() . t('statistics'));
		$card->addField(GDT_Paragraph::make()->text('kk_info_statistics'));
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
		$card->addField(GDT_UInt::make('loc')->initial($loc['loc']));
		return $card;
	}

	private static function statsField(string $key): GDT
	{
		return Module_KassiererCard::instance()->getConfigColumn($key);
	}

	public function getMethodTitle(): string
	{
		return t('statistics');
	}

}
