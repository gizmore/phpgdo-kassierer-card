<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;

/**
 * Conversion type for stars to X conversion. X can be user_level or credits.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class GDT_ConversionType extends GDT_Enum
{
	const CREDITS = 'credits';
	const LEVEL = 'level';
	
	protected function __construct()
	{
		parent::__construct();
		$this->enumValues(self::CREDITS, self::LEVEL);
	}
	
}
