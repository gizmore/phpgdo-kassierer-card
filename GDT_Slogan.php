<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_ComboBox;

final class GDT_Slogan extends GDT_ComboBox
{
	protected function __construct()
	{
		parent::__construct();
		$this->completionHref(href('KassiererCard', 'CompleteSlogan'));
	}
	
}
