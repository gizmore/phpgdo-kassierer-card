<?php
namespace GDO\KassiererCard\Method;

/**
 * Invitation BackSide is similiar the th front side, but it has a slogan and infotext on it.
 *
 * @author gizmore
 */
final class InvitationBackSide extends InvitationFrontSide
{

	protected function getSVGTemplateName(): string { return 'svg/card_back_invitation.php.svg'; }

	public function getMethodTitle(): string
	{
		return t('back_side');
	}

}
