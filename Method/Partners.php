<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\DB\Query;
use GDO\KassiererCard\KC_Partner;
use GDO\Table\GDT_Table;
use GDO\Table\MethodQueryCards;

final class Partners extends MethodQueryCards
{

	public function gdoTable(): GDO
	{
		return KC_Partner::table();
	}

	public function getQuery(): Query
	{
		return parent::getQuery()
			->where("p_partnership='kk_partner_active'");
	}

	protected function setupCollection(GDT_Table $table): void
	{
		parent::setupCollection($table);
		$table->text('kk_info_partners_table');
	}

}
