<?php
namespace GDO\KassiererCard\Method;

use GDO\UI\MethodPage;

/**
 * Show dashboard information to partners/companies.
 * 
 * @author gizmore
 */
final class PartnerPage extends MethodPage
{
	public function getMethodTitle(): string
	{
		return t('link_kk_company_page');
	}
	
	public function getPermission() : ?string
	{
		return 'kk_company';
	}
	
}
