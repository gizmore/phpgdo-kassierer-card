<?php
namespace GDO\KassiererCard\Method;

use DateTime;
use GDO\Core\GDO;
use GDO\Core\GDT;
use GDO\Core\GDT_Tuple;
use GDO\Date\GDT_Month;
use GDO\Date\GDT_Week;
use GDO\Date\GDT_Year;
use GDO\DB\Query;
use GDO\KassiererCard\GDT_CompetitionSection;
use GDO\KassiererCard\KC_OfferRedeemed;
use GDO\Table\MethodQueryList;

/**
 * Show competition results.
 *
 * @author gizmore
 *
 */
final class Competitions extends MethodQueryList
{

	public function isSearched(): bool
	{
		return false;
	}

	public function isFiltered(): bool
	{
		return false;
	}

	public function isOrdered(): bool
	{
		return false;
	}

	public function gdoTable(): GDO
	{
// 		switch ($this->getSection())
// 		{
// 			case 'business_of_the_week':
// 			case 'business_of_the_month':
// 			case 'business_of_the_year':
// 				return KC_Business::table();
// 			case 'company_of_the_week':
// 			case 'company_of_the_month':
// 			case 'company_of_the_year':
// 				return KC_Partner::table();
// 			case 'offer_of_the_week':
// 			case 'offer_of_the_month':
// 			case 'offer_of_the_year':
// 				return KC_Offer::table();
// 			default:
// 				return GDO_User::table();
// 		}
		return KC_OfferRedeemed::table();
	}

	public function gdoParameters(): array
	{
		return [
			GDT_CompetitionSection::make('section')->notNull()->initial(GDT_CompetitionSection::OFFER_OF_THE_WEEK),
			GDT_Week::make('week')->minDate(GDO_SITECREATED)->initialNow(),
			GDT_Month::make('month')->minDate(GDO_SITECREATED)->initialNow(),
			GDT_Year::make('year')->minDate(GDO_SITECREATED)->initialNow(),
		];
	}

	public function getTableTitle(): string
	{
		$table = $this->getTable();
		return t('competition_table', [
			$this->gdoParameter('section')->renderCell(),
			$table->countItems(),
			$this->getPage(),
			$this->table->pagemenu->getPageCount(),
		]);
	}

	public function getQuery(): Query
	{
		$query = parent::getQuery();
		GDT_CompetitionSection::filterCompetitionQuery($query, $this->getSection());
		return $query;
	}

	public function getSection(): string
	{
		return $this->gdoParameterVar('section');
	}

	public function execute(): GDT
	{
		return GDT_Tuple::makeWith(
			$this->gdoParameter('section'),
			$this->renderTable(),
		);
	}

	public function getDateTimeStart(): DateTime
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

}
