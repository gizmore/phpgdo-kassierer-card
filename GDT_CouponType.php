<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT;
use GDO\Core\GDT_Enum;
use GDO\Util\Arrays;

/**
 * Coupon type changes the URL in QR code to Registration or EnterCode.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_CouponType extends GDT_Enum
{
	public function defaultLabel(): self
	{
		return $this->label('type');
	}
	
	protected function __construct()
	{
		parent::__construct();
		$this->enumValues('kk_coupon', 'kk_cashier', 'kk_company', 'kk_customer');
	}

	public function displayVar(string $var = null): string
	{
		return $var === null ? GDT::EMPTY_STRING : t($var);
	}
	
	#################
	### No Coupon ###
	#################
	public function noCoupon(bool $noCoupon=true) : self
	{
		$this->enumValues = Arrays::remove($this->enumValues, 'kk_coupon');
		return $this;
	}

	##################
	### No Company ###
	##################
	public bool $noCompany = false;
	public function noCompany(bool $noCompany=true): self
	{
		$this->enumValues = Arrays::remove($this->enumValues, 'kk_company');
		return $this;
	}
	
}
