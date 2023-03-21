<?php
namespace GDO\KassiererCard;

use GDO\Admin\MethodAdmin;

trait MethodKCAdmin
{

	use MethodAdmin;

	public function getPermission(): ?string
	{
		return 'kk_manager';
	}

	public function onRenderTabs(): void
	{
		$this->renderAdminBar();
		Module_KassiererCard::instance()->addAdminBar();
	}

}
