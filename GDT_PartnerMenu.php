<?php
namespace GDO\KassiererCard;

use GDO\UI\GDT_Menu;
use GDO\UI\GDT_Link;

/**
 * Partner right panel menu.
 * 
 * @author gizmore
 */
final class GDT_PartnerMenu extends GDT_Menu
{

	protected function __construct()
	{
		parent::__construct();
		$this->addFields(
			GDT_Link::make('link_kk_partner_page')->href(href('KassiererCard', 'PartnerPage')),
			GDT_Link::make('link_kk_partner_edit')->href(href('KassiererCard', 'PartnerEdit')),
			GDT_Link::make('link_kk_partner_scans')->href(href('KassiererCard', 'PartnerScansOffer')),
			GDT_Link::make('link_kk_partner_enter')->href(href('KassiererCard', 'PartnerEntersOffer')),
			GDT_Link::make('link_kk_partner_offers')->href(href('KassiererCard', 'PartnerOffers')),
		);
	}
	
}
