<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_String;


final class GDT_SignupCode extends GDT_String
{
	protected function __construct()
	{
		parent::__construct();
		$this->ascii()->caseS();
		$this->icon('code');
	}
	
}
