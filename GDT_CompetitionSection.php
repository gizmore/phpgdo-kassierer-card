<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;

/**
 * A Competition selection.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_CompetitionSection extends GDT_Enum
{
	const CASHIER_OF_THE_WEEK = 'cashier_otw';
	const CASHIER_OF_THE_MONTH = 'cashier_otm';
	const CASHIER_OF_THE_YEAR = 'cashier_oty';

	const CUSTOMER_OF_THE_WEEK = 'customer_otw';
	const CUSTOMER_OF_THE_MONTH = 'customer_otm';
	const CUSTOMER_OF_THE_YEAR = 'customer_oty';

	const COMPANY_OF_THE_WEEK = 'company_otw';
	const COMPANY_OF_THE_MONTH = 'company_otm';
	const COMPANY_OF_THE_YEAR = 'company_oty';
	
	const BUSINESS_OF_THE_WEEK = 'business_otw';
	const BUSINESS_OF_THE_MONTH = 'business_otm';
	const BUSINESS_OF_THE_YEAR = 'business_oty';
	
	const OFFER_OF_THE_WEEK = offer_otw;
	const OFFER_OF_THE_MONTH = offer_otm;
	const OFFER_OF_THE_YEAR = offer_oty;
	
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
