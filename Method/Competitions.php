<?php
namespace GDO\KassiererCard\Method;

use GDO\User\GDO_User;
use GDO\Table\MethodQueryList;
use GDO\DB\Query;
use GDO\Date\GDT_Week;
use GDO\KassiererCard\GDT_CompetitionSection;
use GDO\Date\GDT_Year;
use GDO\Date\GDT_Month;

/**
 * Show competition results.
 * 
 * @author gizmore
 *
 */
final class Competitions extends MethodQueryList
{
	public function gdoTable()
	{
		return GDO_User::table();
	}
	
	public function gdoParameters() : array
	{
		return [
			GDT_CompetitionSection::make('section')->notNull(),
			GDT_Week::make('week')->minDate(GDO_SITECREATED),
			GDT_Month::make('month')->minDate(GDO_SITECREATED),
			GDT_Year::make('year')->minDate(GDO_SITECREATED),
		];
	}
	
	public function getQuery() : Query
	{
		return parent::getQuery();
	}

}
