<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;
use GDO\DB\Query;

/**
 * A Competition selection.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_CompetitionSection extends GDT_Enum
{
	const CASHIER_OF_THE_WEEK = 'cashier_of_the_week';
	const CASHIER_OF_THE_MONTH = 'cashier_of_the_month';
	const CASHIER_OF_THE_YEAR = 'cashier_of_the_year';

	const CUSTOMER_OF_THE_WEEK = 'customer_of_the_week';
	const CUSTOMER_OF_THE_MONTH = 'customer_of_the_month';
	const CUSTOMER_OF_THE_YEAR = 'customer_of_the_year';

	const COMPANY_OF_THE_WEEK = 'company_of_the_week';
	const COMPANY_OF_THE_MONTH = 'company_of_the_month';
	const COMPANY_OF_THE_YEAR = 'company_of_the_year';
	
	const BUSINESS_OF_THE_WEEK = 'business_of_the_week';
	const BUSINESS_OF_THE_MONTH = 'business_of_the_month';
	const BUSINESS_OF_THE_YEAR = 'business_of_the_year';
	
	const OFFER_OF_THE_WEEK = 'offer_of_the_week';
	const OFFER_OF_THE_MONTH = 'offer_of_the_month';
	const OFFER_OF_THE_YEAR = 'offer_of_the_year';
	
	public static function isWeekly(string $section) : bool { return str_ends_with($section, 'week'); }
	public static function isMonthly(string $section) : bool { return str_ends_with($section, 'month'); }
	public static function isYearly(string $section) : bool { return str_ends_with($section, 'year'); }
	
	public static function filterCompetitionQuery(Query $query, string $section) : void
	{
		switch ($section)
		{
			
		}
	}
	
	protected function __construct()
	{
		parent::__construct();
		$this->icon('trophy');
		$this->enumValues(
			self::CASHIER_OF_THE_WEEK,
			self::CASHIER_OF_THE_MONTH,
			self::CASHIER_OF_THE_YEAR,
			
			self::CUSTOMER_OF_THE_WEEK,
			self::CUSTOMER_OF_THE_MONTH,
			self::CUSTOMER_OF_THE_YEAR,
			
			self::COMPANY_OF_THE_WEEK,
			self::COMPANY_OF_THE_MONTH,
			self::COMPANY_OF_THE_YEAR,
			
			self::BUSINESS_OF_THE_WEEK,
			self::BUSINESS_OF_THE_MONTH,
			self::BUSINESS_OF_THE_YEAR,
			
			self::OFFER_OF_THE_WEEK,
			self::OFFER_OF_THE_MONTH,
			self::OFFER_OF_THE_YEAR,
		);
	}
	
}
