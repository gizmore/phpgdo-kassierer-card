<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT;
use GDO\Core\GDT_Enum;

/**
 * 3 Account types.
 *
 * @author gizmore
 */
final class GDT_AccountType extends GDT_Enum
{

	# not an account type! ^^
	public const COUPON = 'kk_coupon';

	public const CASHIER = 'kk_cashier';
	public const COMPANY = 'kk_company'; # partner
	public const CUSTOMER = 'kk_customer';

	# non account type, but permission
	public const MANAGER = 'kk_manager';
	public const DISTRIBUTOR = 'kk_distributor';

	protected function __construct()
	{
		parent::__construct();
		$this->enumValues(self::CASHIER, self::COMPANY, self::CUSTOMER);
		$this->notNull();
		$this->emptyLabel('lbl_choose_account_type');
	}

	public function defaultLabel(): self
	{
		return $this->label('type');
	}

	public function displayVar(string $var = null): string
	{
		return $var === null ? GDT::EMPTY_STRING : t($var);
	}

}
