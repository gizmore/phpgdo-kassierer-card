<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\MethodCompletion;
use GDO\Core\GDO;
use GDO\DB\Query;
use GDO\KassiererCard\KC_Business;

/**
 * Autocompletion for a KC_Business.
 *
 * @author gizmore
 */
final class BusinessCompletion extends MethodCompletion
{
	protected function gdoTable(): GDO
	{
		return KC_Business::table();
	}
	
	protected function buildQuery() : Query
	{
		$term = $this->getSearchTerm();
		$eterm = GDO::escapeSearchS($term);
		return $this->gdoTable()->select('*')
			->joinObject('biz_address')
			->joinObject('biz_partner')
			->where("address_street LIKE '%{$eterm}%'")
			->orWhere("address_company LIKE '%{$eterm}%'")
			->orWhere("address_name LIKE '%{$eterm}%'")
			->orWhere("biz_owner_t.user_name LIKE '%{$eterm}%'")
			->orWhere("address_city LIKE '%{$eterm}%'")
			->limit($this->getMaxSuggestions());
	}
	
	public function getMethodTitle() : string
	{
		return "Autocompletion for kassierercard stores.";
	}
	
	public function getMethodDescription() : string
	{
		return "Autocompletion for KassiererCard.org stores and businesses.";
	}
	
}
