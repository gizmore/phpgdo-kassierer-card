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
class FrontSide extends Method
{
	protected function getSVGTemplateName() : string { return 'svg/card_front.php'; }
	
	public function isAjax() : bool { return true; }
	
	public function getMethodTitle(): string
	{
		return t('front_side');
	}
	
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
		hdr('Content-Type: image/svg+xml');
		$tpl = $this->getSVGTemplateName();
		$tVars = ['coupon' => $this->getCoupon()];
		return GDT_Template::make()->template('KassiererCard', $tpl, $tVars);
	}
	
}
