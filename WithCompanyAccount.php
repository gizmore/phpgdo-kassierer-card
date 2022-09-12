<?php
namespace GDO\KassiererCard;

trait WithCompanyAccount
{
	public function beforeExecute() : void
	{
		Module_KassiererCard::instance()->addCompanyBar();
	}
	
	
}
