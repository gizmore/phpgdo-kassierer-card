<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\GDT_Table;
use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Partner;

final class Partners extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Partner::table();
	}

	protected function setupCollection(GDT_Table $table)
	{
		parent::setupCollection($table);
		$table->text('kk_info_partners_table');
	}

}
