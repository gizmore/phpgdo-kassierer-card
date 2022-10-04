<?php
namespace GDO\KassiererCard\Method;

use GDO\Table\MethodQueryList;
use GDO\KassiererCard\KC_Offer;
use GDO\DB\Query;
use GDO\User\GDO_User;

/**
 * Partner overview of their offers.
 * 
 * @author gizmore
 *
 */
final class PartnerOffers extends MethodQueryList
{
	public function getMethodTitle() : string
	{
		return t('link_kk_partner_offers');
	}
	
	public function gdoTable()
	{
		return KC_Offer::table();
	}
	
	public function getQuery() : Query
	{
		$user = GDO_User::current();
		return parent::getQuery()
			->joinObject('o_partner')
			->where("o_partner_t.p_user={$user->getID()}");
	}
	
}

