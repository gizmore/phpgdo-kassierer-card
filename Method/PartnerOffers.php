<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\DB\Query;
use GDO\KassiererCard\KC_Offer;
use GDO\Table\MethodQueryList;
use GDO\User\GDO_User;

/**
 * Partner overview of their offers.
 *
 * @author gizmore
 *
 */
final class PartnerOffers extends MethodQueryList
{

	public function getMethodTitle(): string
	{
		return t('link_kk_company_offers');
	}

	public function gdoTable(): GDO
	{
		return KC_Offer::table();
	}

	public function gdoQuery(): Query
	{
		$user = GDO_User::current();
		return parent::gdoQuery()
			->joinObject('o_partner')
			->where("o_partner_t.p_user={$user->getID()}");
	}

}
