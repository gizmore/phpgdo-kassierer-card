<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT;
use GDO\Core\GDT_Enum;
use GDO\Util\Arrays;

/**
 * Coupon type changes the URL in QR code to Registration or EnterCode.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class GDT_CouponType extends GDT_Enum
{

	public bool $noCompany = false;

	protected function __construct()
	{
		parent::__construct();
		$this->enumValues('kk_coupon', 'kk_cashier', 'kk_company', 'kk_customer');
	}

	public function defaultLabel(): self
	{
		return $this->label('type');
	}

	#################
	### No Coupon ###
	#################

	public function displayVar(string $var = null): string
	{
		return $var === null ? GDT::EMPTY_STRING : t($var);
	}

	##################
	### No Company ###
	##################

	public function noCoupon(bool $noCoupon = true): self
	{
		$this->enumValues = Arrays::remove($this->enumValues, 'kk_coupon');
		return $this;
	}

	public function noCompany(bool $noCompany = true): self
	{
		$this->enumValues = Arrays::remove($this->enumValues, 'kk_company');
		return $this;
	}

}
