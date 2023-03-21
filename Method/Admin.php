<?php
namespace GDO\KassiererCard\Method;

use GDO\KassiererCard\MethodKCAdmin;
use GDO\UI\MethodPage;

/**
 * Admin dashboard.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class Admin extends MethodPage
{

	use MethodKCAdmin;

	public function getMethodTitle(): string
	{
		return 'Staff - Area';
	}

}
