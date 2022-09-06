<?php
namespace GDO\KassiererCard\tpl\page;
use GDO\UI\GDT_Accordeon;
use GDO\UI\GDT_Pre;
?>
<h2><?=sitename()?></h2>
<h3><?=t('mt_faq')?></h3>
<p><?=t('md_faq')?></p>
<?php 
foreach (t('kk_faq') as $faq)
{
	GDT_Accordeon::make()->titleRaw($faq['title'])
		->addField(GDT_Pre::make()->var($faq['infos']));
}
