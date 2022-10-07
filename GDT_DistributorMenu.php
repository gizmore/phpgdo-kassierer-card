<?php
namespace GDO\KassiererCard;

use GDO\UI\GDT_Menu;
use GDO\UI\GDT_Link;

/**
 * Cashier right panel menu.
 * 
 * @author gizmore
 */
final class GDT_DistributorMenu extends GDT_Menu
{

	protected function __construct()
	{
		parent::__construct();
		$this->vertical();
		$mod = Module_KassiererCard::instance();
		$this->label('perm_kk_distributor');
		$this->addFields(
			GDT_Link::make('create_company')->href($mod->href('CompanyCrud'))->icon('add'),
			GDT_Link::make('create_business')->href($mod->href('BusinessCrud'))->icon('add'),
		);
	}
	
}
