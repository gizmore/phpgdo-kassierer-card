<?php
namespace GDO\KassiererCard;

use GDO\UI\GDT_Menu;
use GDO\UI\GDT_Link;

/**
 * Cashier right panel menu.
 * 
 * @author gizmore
 */
final class GDT_CustomerMenu extends GDT_Menu
{

	protected function __construct()
	{
		parent::__construct();
		$mod = Module_KassiererCard::instance();
		$this->label('perm_kk_customer');
		$this->addFields(
			GDT_Link::make('create_coupon')->href($mod->href('CreateCoupon'))->icon('bee'),
			GDT_Link::make('invite_users')->href($mod->href('Invite'))->icon('diamond'),
			GDT_Link::make('redeem_offer')->href($mod->href('RedeemOffer'))->icon('sun'),
		);
	}
	
}
