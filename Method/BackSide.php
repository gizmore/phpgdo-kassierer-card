<?php
namespace GDO\KassiererCard\Method;

/**
 * A backside image is calling a different template.
 * 
 * @author gizmore
 */
final class BackSide extends FrontSide
{
	
	protected function getSVGTemplateName() : string { return 'svg/card_back.php'; }
	
	public function getMethodTitle(): string
	{
		return t('back_side');
	}

}
