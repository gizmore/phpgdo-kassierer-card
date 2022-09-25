<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Working;
use GDO\KassiererCard\GDT_Business;
use GDO\DB\Query;
use GDO\KassiererCard\KC_Business;
use GDO\Core\GDT_Tuple;

final class Employees extends MethodQueryList
{
	public function gdoTable()
	{
		return KC_Working::table();
	}
	
	public function gdoParameters() : array
	{
		return [
			GDT_Business::make('business'),
		];
	}
	
	public function getBusiness() : ?KC_Business
	{
		return $this->gdoParameterValue('business');
	}
	
	public function getQuery() : Query
	{
		$query = parent::getQuery();
		if ($b = $this->getBusiness())
		{
			$query->where("work_business={$b->getID()}");
		}
		return $query;
	}
	
	public function execute()
	{
		if ($business = $this->getBusiness())
		{
			return GDT_Tuple::makeWith($business->getCard(), parent::execute());
		}
		return parent::execute();
	}
	
}
