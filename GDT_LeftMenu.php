<?php
namespace GDO\KassiererCard;

use GDO\UI\GDT_Link;
use GDO\UI\GDT_Menu;

/**
 * The Public left Menu Submenu.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_LeftMenu extends GDT_Menu
{
	
	protected function __construct()
	{
		parent::__construct();
		$this->vertical();
		$mod = Module_KassiererCard::instance();
		$this->labelRaw(sitename());
		$this->addFields(
			GDT_Link::make()->href($mod->href('Offers'))->text('link_kk_offers', [KC_Offer::getAvailableOffers()])->icon('star'),
			GDT_Link::make('link_kk_companys')->href($mod->href('Partners'))->textArgs(KC_Partner::numTotal())->icon('icecream'),
			GDT_Link::make()->href($mod->href('Competitions'))->icon('trophy')->text('link_kk_competitions', [count(GDT_CompetitionSection::make()->enumValues)]),
			GDT_Link::make()->href($mod->href('Statistics'))->text('link_kk_statistics', [23])->icon('amt'),
			GDT_Link::make('link_kk_businesses')->href($mod->href('Businesses'))->textArgs(KC_Business::numTotal())->icon('house'),
			GDT_Link::make('link_kk_employees')->href($mod->href('Employees'))->textArgs(KC_Working::numEmployeesTotal())->icon('work'),
			GDT_Link::make('link_kk_team')->href($mod->href('Team'))->textArgs(8)->icon('users'),
			GDT_Link::make('link_kk_help')->href($mod->href('Help'))->icon('help'),
		);
	}
	
}
