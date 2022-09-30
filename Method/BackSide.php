<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\Method;
use GDO\Core\GDT_Template;
use GDO\KassiererCard\GDT_Coupon;
use GDO\KassiererCard\KC_Coupon;
use GDO\File\Method\GetFile;

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
		$coupon = $this->getCoupon();
		$offer = $coupon->getOffer();
		if ($backImage = $offer->getBacksideImage())
		{
			return GetFile::make()->executeWithFile($backImage);
		}
		header('Content-Type: image/svg+xml');
		$tVars = [
			'coupon' => $coupon,
			'offer' => $offer,
		];
		return GDT_Template::make()->template('Kassierercard', 'svg/card_back.php', $tVars);
	}
	
}
