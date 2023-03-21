<?php
namespace GDO\KassiererCard\Method;

use GDO\UI\MethodPage;

/**
 *
 * @author gizmore
 *
 */
final class Help extends MethodPage
{

	public function getMethodTitle(): string
	{
		return t('mt_faq');
	}

	public function getMethodDescription(): string
	{
		return t('md_faq');
	}

}
