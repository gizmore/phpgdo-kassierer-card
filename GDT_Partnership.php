<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_Enum;

/**
 * The partnership status for a merchandize partner.
 * YES/NO/WANTED
 * @author gizmore
 */
final class GDT_Partnership extends GDT_Enum
{
	const WANTED = 'kk_partner_wanted';
	const ACTIVE = 'kk_partner_active';
	const REFUSED = 'kk_partner_refused';
	
	protected function __construct()
	{
		parent::__construct();
		$this->icon('hands');
		$this->label('partnership');
		$this->enumValues(self::WANTED, self::ACTIVE, self::REFUSED);
	}
	
}
