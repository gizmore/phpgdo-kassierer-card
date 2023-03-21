<?php
namespace GDO\KassiererCard;

use GDO\Core\GDT_UInt;

/**
 * Amount of coupon stars.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class GDT_CouponStars extends GDT_UInt
{

	###########
	### Int ###
	###########
// 	public ?float $min = 1;
// 	public ?float $max = 5;

	protected function __construct()
	{
		parent::__construct();
		$this->notNull();
		$this->bytes(2);
// 		$this->initial('1');
	}

	###########
	### GDT ###
	###########
	public function defaultLabel(): self
	{
		return $this->label('kk_stars');
	}

	##############
	### Render ###
	##############
// 	public function renderCell() : string
// 	{
// 		return 'TEST';
// 	}

}
