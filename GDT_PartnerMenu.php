<?php
namespace GDO\KassiererCard;

use GDO\UI\GDT_Link;
use GDO\UI\GDT_Menu;

/**
 * Partner/Company right panel menu.
 *
 * @author gizmore
 */
final class GDT_PartnerMenu extends GDT_Menu
{

	protected function __construct()
	{
		parent::__construct();
		$this->vertical();
		$this->label('perm_kk_company');
		$this->addFields(
			GDT_Link::make('link_kk_company_page')->href(href('KassiererCard', 'PartnerPage')),
			GDT_Link::make('link_kk_company_edit')->href(href('KassiererCard', 'PartnerEdit')),
			GDT_Link::make('link_kk_company_scans')->href(href('KassiererCard', 'PartnerScansOffer')),
			GDT_Link::make('link_kk_company_enter')->href(href('KassiererCard', 'PartnerEntersOffer')),
			GDT_Link::make('link_kk_company_offers')->href(href('KassiererCard', 'PartnerOffers')),
		);
	}

}
