<?php
namespace GDO\KassiererCard\Method;

use GDO\UI\MethodPage;
use GDO\KassiererCard\MethodKCAdmin;

/**
 * Admin dashboard.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class Admin extends MethodPage
{
	
	use MethodKCAdmin;
	
	public function getMethodTitle(): string
	{
		return 'Staff - Area';
	}
	
}
