<?php
namespace GDO\KassiererCard\Method;

use GDO\UI\MethodPage;

/**
 * Show information to partners.
 * 
 * @author gizmore
 */
final class PartnerPage extends MethodPage
{
	public function getPermission() : ?string
	{
		return 'kk_company';
	}
	
}