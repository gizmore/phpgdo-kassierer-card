<?php
namespace GDO\KassiererCard\Method;

use GDO\User\GDO_User;
use GDO\DB\Query;
use GDO\Date\GDT_Week;
use GDO\KassiererCard\GDT_CompetitionSection;
use GDO\Date\GDT_Year;
use GDO\Date\GDT_Month;
use GDO\Table\MethodQueryList;

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
			GDT_CompetitionSection::make('section')->notNull()->initial(GDT_CompetitionSection::OFFER_OF_THE_WEEK),
			GDT_Week::make('week')->minDate(GDO_SITECREATED)->initialNow(),
			GDT_Month::make('month')->minDate(GDO_SITECREATED)->initialNow(),
			GDT_Year::make('year')->minDate(GDO_SITECREATED)->initialNow(),
		];
	}
	
	public function getSection() : string
	{
		return $this->gdoParameterVar('section');
	}
	
	public function getDateTimeStart() : \DateTime
	{
		$section = $this->getSection();
		$key = 'year';
		if (GDT_CompetitionSection::isWeekly($section))
		{
			$key = 'week';
		}
		elseif (GDT_CompetitionSection::isMonthly($section))
		{
			$key = 'month';
		}
		return $this->gdoParameterValue($key);
	}
	
	public function getQuery() : Query
	{
		$query = parent::getQuery();
		GDT_CompetitionSection::filterCompetitionQuery($query, $this->getSection());
		return $query;
	}
	

}
