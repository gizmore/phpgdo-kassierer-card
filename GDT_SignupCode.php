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
	
	public function inputToVar($input) : ?string
	{
		if ($input === null)
		{
			return null;
		}
		$input = preg_replace('#[^0-9A-Z]#', '', strtoupper($input));
		return $input;
	}
	
}
