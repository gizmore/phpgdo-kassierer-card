<?php
namespace GDO\KassiererCard\tpl\page;
use GDO\UI\GDT_Accordeon;
use GDO\UI\GDT_Paragraph;
?>
<h2><?=sitename()?></h2>
<h3><?=t('mt_faq')?></h3>
<p><?=t('md_faq')?></p>
<?php
$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t1');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b1', [sitename()]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t2');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b2', [sitename()]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t3');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b3', [sitename()]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t4');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b4', [sitename()]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t5');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b5', [sitename()]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t6');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b6', [sitename()]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t7');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b7', [sitename()]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t8');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b8', [sitename()]));
echo $acc->render();

