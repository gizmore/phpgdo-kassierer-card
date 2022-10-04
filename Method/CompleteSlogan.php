<?php
namespace GDO\KassiererCard\Method;

use GDO\Core\GDO;
use GDO\Core\MethodCompletion;
use GDO\KassiererCard\KC_Slogan;

/**
 * Autocompletion for slogans.
 * 
 * @author gizmore
 * @version 7.0.1
 */
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
