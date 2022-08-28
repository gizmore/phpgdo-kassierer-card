<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_ObjectSelect;

final class GDT_Business extends GDT_ObjectSelect
{
	public function defaultLabel() : self
	{
		return $this->label('business');
	}
	
	protected function __construct()
	{
		parent::__construct();
		$this->table(KC_Business::table());
		$this->completionHref(href('KassiererCard', 'BusinessCompletion'));
	}
	
}