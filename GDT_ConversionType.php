<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;

/**
 * Conversion type for stars to X conversion. X can be user_level or credits.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class GDT_ConversionType extends GDT_Enum
{

	public const CREDITS = 'credits';
	public const LEVEL = 'level';

	protected function __construct()
	{
		parent::__construct();
		$this->enumValues(self::CREDITS, self::LEVEL);
	}

}
