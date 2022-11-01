<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\GDT_Table;
use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Partner;
use GDO\DB\Query;

final class Partners extends MethodQueryList
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
