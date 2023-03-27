<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\Core\GDT;
use GDO\Core\GDT_Tuple;
use GDO\DB\Query;
use GDO\KassiererCard\GDT_Business;
use GDO\KassiererCard\KC_Business;
use GDO\KassiererCard\KC_Working;
use GDO\Table\MethodQueryList;

final class Employees extends MethodQueryList
{

	public function gdoTable(): GDO
	{
		return KC_Working::table();
	}

	public function gdoParameters(): array
	{
		return [
			GDT_Business::make('business'),
		];
	}

	public function getQuery(): Query
	{
		$query = parent::getQuery();
		if ($b = $this->getBusiness())
		{
			$query->where("work_business={$b->getID()}");
		}
		return $query;
	}

	public function getBusiness(): ?KC_Business
	{
		return $this->gdoParameterValue('business');
	}

	public function execute(): GDT
	{
		if ($business = $this->getBusiness())
		{
			return GDT_Tuple::makeWith($business->getCard(), parent::execute());
		}
		return parent::execute();
	}

}
