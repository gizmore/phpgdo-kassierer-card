<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\Method;
use GDO\UI\GDT_Card;
use GDO\User\GDO_User;
use GDO\Core\GDT_UInt;

/**
 * Show Statistics.
 * 
 * @author gizmore
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
		$card->gdo(GDO_User::findById(2));
		$card->creatorHeader();
		$card->titleRaw(sitename());
		$card->addField(GDT_UInt::make('kk_cards_printed')->var('10'));
		return $card;
	}

}
