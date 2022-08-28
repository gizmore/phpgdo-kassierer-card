<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\MethodCompletion;
use GDO\Core\GDT_Array;
use GDO\Core\GDO;
use GDO\KassiererCard\KC_Business;

/**
 * Autocompletion for a KC_Business.
 * 
 * @author gizmore
 */
final class BusinessCompletion extends MethodCompletion
{
	public function getMethodTitle() : string
	{
		return "Autocompletion for kassierercard stores.";
	}
	
	public function getMethodDescription() : string
	{
		return "Autocompletion for kassierercard stores.";
	}
	
	public function execute()
	{
		$q = $this->getSearchTerm();
		$q = GDO::escapeSearchS($q);
		$query = KC_Business::table()->select()->
			joinObject('biz_address')->
			where("address_company LIKE '%{$q}%'")->
			orWhere("address_street LIKE '%{$q}%'")->
			orWhere("address_city LIKE '%{$q}%'")->
			limit($this->getMaxSuggestions())->
			uncached();
		$result = $query->exec();
		$response = [];
		/** @var $business KC_Business **/
		while ($business = $result->fetchObject())
		{
			$response[] = [
				'id' => $business->getID(),
				'text' => $business->renderName(),
				'display' => $business->renderOption(),
			];
		}
		return GDT_Array::make()->value($response);
	}
	
}
