<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;
use GDO\Core\GDT;

final class GDT_CouponType extends GDT_Enum 
{
	const KIND = 'kind';
	const FAST = 'fast';
	const HELP = 'help';
	
	const COAL = 'coal';
	
	protected function __construct()
	{
		parent::__construct();
		$this->enumValues(self::KIND, self::FAST, self::HELP);
		$this->tooltip('tt_coup_type');
		$this->notNull();
	}
	
	public function allowEmpty(bool $allowEmpty=true) : self
	{
		return $this->emptyInitial('please_choose');
	}
	
	public function displayVar(string $var=null) : string
	{
		return $var === null ? '' : t('coupon_' . $var);
	}
	
}
