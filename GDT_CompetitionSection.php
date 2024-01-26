<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;
use GDO\DB\Query;
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;

/**
 * A Competition selection.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class GDT_CompetitionSection extends GDT_Enum
{

	public const CASHIER_OF_THE_WEEK = 'cashier-of-the-week';
	public const CASHIER_OF_THE_MONTH = 'cashier-of-the-month';
	public const CASHIER_OF_THE_YEAR = 'cashier-of-the-year';

	public const CUSTOMER_OF_THE_WEEK = 'customer-of-the-week';
	public const CUSTOMER_OF_THE_MONTH = 'customer-of-the-month';
	public const CUSTOMER_OF_THE_YEAR = 'customer-of-the-year';

	public const COMPANY_OF_THE_WEEK = 'company-of-the-week';
	public const COMPANY_OF_THE_MONTH = 'company-of-the-month';
	public const COMPANY_OF_THE_YEAR = 'company-of-the-year';

	public const BUSINESS_OF_THE_WEEK = 'business-of-the-week';
	public const BUSINESS_OF_THE_MONTH = 'business-of-the-month';
	public const BUSINESS_OF_THE_YEAR = 'business-of-the-year';

	public const OFFER_OF_THE_WEEK = 'offer-of-the-week';
	public const OFFER_OF_THE_MONTH = 'offer-of-the-month';
	public const OFFER_OF_THE_YEAR = 'offer-of-the-year';

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

	public static function isWeekly(string $section): bool { return str_ends_with($section, 'week'); }

	public static function isMonthly(string $section): bool { return str_ends_with($section, 'month'); }

	public static function isYearly(string $section): bool { return str_ends_with($section, 'year'); }

	public static function filterCompetitionQuery(Query $query, string $section): void
	{
		switch ($section)
		{
			case self::CASHIER_OF_THE_WEEK:
			case self::CASHIER_OF_THE_MONTH:
			case self::CASHIER_OF_THE_YEAR:
// 				$cashierId = GDO_Permission::getByName('kk_cashier')->getID();
// 				$query->join('JOIN gdo_userpermission up ON up.perm_user_id=gdo_user.user_id AND up.perm_perm_id='.$cashierId);
// 				$query->join('JOIN gdo_usersetting us_stars ON us_stars.uset_user=gdo_user.user_id AND us_stars.uset_name="stars_earned"');
				break;
		}
	}

	public function renderCell(): string
	{
		return $this->displayVar($this->getVar());
	}

	public function renderHTML(): string
	{
		$bar = GDT_Bar::make()->horizontal(true, true);
		foreach ($this->enumValues as $var)
		{
			$href = href('KassiererCard', 'Competitions', "&section={$var}");
			$link = GDT_Link::make()->href($href)
				->textRaw($this->displayVar($var));
			$bar->addField($link);
		}
		return $bar->render();
	}

}
