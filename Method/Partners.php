<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\GDT_Table;
use GDO\KassiererCard\KC_Partner;
use GDO\DB\Query;
use GDO\Table\MethodQueryCards;

final class Partners extends MethodQueryCards
{
	public function gdoTable()
	{
		return KC_Partner::table();
	}

	public function getQuery(): Query
	{
		return parent::getQuery()
			->where("p_partnership='kk_partner_active'");
	}
	
	protected function setupCollection(GDT_Table $table)
	{
		parent::setupCollection($table);
		$table->text('kk_info_partners_table');
	}

}
