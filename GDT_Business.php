<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_ObjectSelect;

/**
 * Should have been named store.
 * 
 * @author gizmore
 */
final class GDT_Business extends GDT_ObjectSelect
{
	public function defaultLabel(): static
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
