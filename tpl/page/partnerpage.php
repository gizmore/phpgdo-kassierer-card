<?php
namespace GDO\KassiererCard\tpl\page;
use GDO\KassiererCard\GDT_PartnerMenu;
?>
<?=GDT_PartnerMenu::make()->render()?>

<h2><?=sitename()?> <?=t('link_kk_company_page')?></h2>
<p><?=t('info_kk_company_admin', [sitename()])?></p>

