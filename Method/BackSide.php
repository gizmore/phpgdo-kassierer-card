<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\Method;
use GDO\Core\GDT_Template;
use GDO\KassiererCard\GDT_Coupon;
use GDO\KassiererCard\KC_Coupon;

/**
 * 
 * @author gizmore
 *
 */
final class BackSide extends Method
{
	public function isAjax() : bool { return true; }
	
	public function gdoParameters() : array
	{
		return [
			GDT_Coupon::make('token')->notNull()->onlyOwnCreated(),
		];
	}
	
	public function getCoupon() : KC_Coupon
	{
		return $this->gdoParameterValue('token');
	}
	
	public function execute()
	{
		header('Content-Type: image/svg+xml');
		$tVars = [
			'coupon' => $this->getCoupon(),
		];
		return GDT_Template::make()->template('Kassierercard', 'svg/card_front.php', $tVars);
	}
	
}
