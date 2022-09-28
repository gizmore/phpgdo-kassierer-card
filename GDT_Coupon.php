<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Object;

final class GDT_Coupon extends GDT_Object
{
	
	protected function __construct()
	{
		parent::__construct();
		$this->table(KC_Coupon::table());
	}
	
	################
	### Only Own ###
	################
	public bool $onlyOwnCreated = false;
	public function onlyOwnCreated(bool $bool=true) : self
	{
		$this->onlyOwnCreated = $bool;
		return $this;
	}
	
}
