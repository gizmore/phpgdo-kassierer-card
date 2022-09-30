<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Offer;
use GDO\Table\GDT_Table;
use GDO\DB\Query;
use GDO\Date\Time;

final class Offers extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Offer::table();
	}
	
	public function getQuery() : Query
	{
		$now = Time::getDateWithoutTime();
		return parent::getQuery()->orWhere("o_expires >= '$now'");
	}
	
	protected function setupCollection(GDT_Table $table) : void
	{
		parent::setupCollection($table);
		$table->text('kk_info_offers');
	}
	
}
