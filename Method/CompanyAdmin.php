<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\Method;
use GDO\UI\GDT_Panel;

final class CompanyAdmin extends Method
{
	public function execute()
	{
		return GDT_Panel::make()->text('info_kk_company_admin');
	}
	
}
