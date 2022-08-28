<?php
namespace GDO\KassiererCard;

use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;

/**
 * A printed coupon to give to an employee.
 * 
 * @author gizmore
 * @version 7.0.1
 */
final class KC_Coupon extends GDO
{
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('coup_id'),
			GDT_CouponType::make('coup_type'),
			GDT_CreatedBy::make('coup_creator'),
			GDT_CreatedAt::make('coup_created'),
		];
	}
	
}
