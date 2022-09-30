<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_ObjectSelect;
use GDO\Date\Time;

/**
 * An offer selection.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_Offer extends GDT_ObjectSelect
{
	protected function __construct()
	{
		parent::__construct();
		$this->notNull();
		$this->table(KC_Offer::table());
	}
	
	public bool $expired = false;
	public function expired(bool $expired=true) : self
	{
		$this->expired = $expired;
		return $this;
	}
	
	public function getChoices()
	{
		$query = KC_Offer::table()->select();
		if (!$this->expired)
		{
			$now = Time::getDateWithoutTime();
			$query->where("o_expires >= '$now'");
		}
		return $query->exec()->fetchAllArray2dObject();
	}
	
}
