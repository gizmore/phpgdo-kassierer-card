<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Object;

/**
 * An offer selection.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_Offer extends GDT_Object
{
	protected function __construct()
	{
		parent::__construct();
		$this->notNull();
		$this->table(KC_Offer::table());
	}
	
}
