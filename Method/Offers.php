<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\Date\Time;
use GDO\DB\Query;
use GDO\KassiererCard\KC_Offer;
use GDO\Table\GDT_Table;
use GDO\Table\MethodQueryCards;

final class Offers extends MethodQueryCards
{

	public function gdoTable(): GDO
	{
		return KC_Offer::table();
	}

	public function getQuery(): Query
	{
		$now = Time::getDateWithoutTime();
		return parent::getQuery()
			->where("o_partnership = 'kk_partner_active'")
			->where("o_expires >= '$now'");
	}

	protected function setupCollection(GDT_Table $table): void
	{
		parent::setupCollection($table);
		$table->text('kk_info_offers');
	}

}
