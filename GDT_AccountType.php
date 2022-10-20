<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;
use GDO\Core\GDT;

/**
 * 3 Account types.
 *
 * @author gizmore
 */
final class GDT_AccountType extends GDT_Enum
{
	# not an account type! ^^
	const COUPON = 'kk_coupon';
	
	const CASHIER = 'kk_cashier';
	const COMPANY = 'kk_company'; # partner
	const CUSTOMER = 'kk_customer';
	
	# non account type, but permission
	const MANAGER = 'kk_manager';
	const DISTRIBUTOR = 'kk_distributor';

	public function defaultLabel(): self
	{
		return $this->label('type');
	}

	protected function __construct()
	{
		parent::__construct();
		$this->enumValues(self::CASHIER, self::COMPANY, self::CUSTOMER);
		$this->notNull();
		$this->emptyLabel('lbl_choose_account_type');
	}

	public function displayVar(string $var = null): string
	{
		return $var === null ? GDT::EMPTY_STRING : t($var);
	}

}
