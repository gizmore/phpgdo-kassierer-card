<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\Core\MethodCompletion;
use GDO\KassiererCard\KC_Slogan;

final class CompleteSlogan extends MethodCompletion
{
	protected function gdoTable(): GDO
	{
		return KC_Slogan::table();
	}
	
	public function itemToCompletionJSON(GDO $item) : array
	{
		return [
			'id' => $item->getID(),
			'text' => $item->renderSlogan(),
			'display' => $item->renderSlogan(),
		];
	}

}
