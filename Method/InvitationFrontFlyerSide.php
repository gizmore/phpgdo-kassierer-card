<?php
namespace GDO\KassiererCard\Method;

/**
 * The Invitation FrontSide Image which is dentical to the normal FrontSide image.
 * 
 * @author gizmore
 * @version 7.0.1
 */
class InvitationFrontFlyerSide extends FrontSide
{
	protected function getSVGTemplateName(): string
	{
		return 'svg/card_front_flyer.php.svg';
	}
	
}
