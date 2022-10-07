<?php
namespace GDO\KassiererCard\tpl\page;
use GDO\UI\GDT_Accordeon;
use GDO\UI\GDT_Paragraph;
use GDO\UI\GDT_Link;
use GDO\KassiererCard\Module_KassiererCard;
use GDO\KassiererCard\KC_Util;
use GDO\Payment\GDT_Money;
?>
<h2><?=sitename()?> - Frequently asked NaNsense</h2>
<h3><?=t('mt_faq')?></h3>
<p><?=t('md_faq')?></p>
<?php
$kk = Module_KassiererCard::instance();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t1');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b1', [sitename()]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t1b');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b1b', []));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t2');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b2', []));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t3');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b3', [
	$kk->cfgFreeStarsPerPeriod(),
	$kk->cfgCustomerCouponModulus(),
]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t4');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b4', []));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t5');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b5', []));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t6');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b6', []));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t7');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b7', []));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t8');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b8', []));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t9');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b9', []));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t10');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b10', []));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t11');
$linkToDo = GDT_Link::anchor($kk->href('ToDo'), t('kk_link_todo'));
$linkGithub = GDT_Link::anchor('https://github.com/gizmore/phpgdo-kassierer-card');
$acc->addField(GDT_Paragraph::make()->text('kk_faq_b11', [
	$linkToDo, $linkGithub]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t12');
$acc->addField(
	GDT_Paragraph::make()->text('kk_faq_b12', [
		GDT_Link::make('link_contact')->href(href('Contact', 'Form'))->render(),
	]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t13');
$periodsPerWeek = 3;
$weeksPerMonth = 4.5;
$monthlyCostPerCustomer = KC_Util::starsToEuro($kk->cfgFreeStarsPerPeriod() * $periodsPerWeek * $weeksPerMonth);
$acc->addField(
	GDT_Paragraph::make()->text('kk_faq_b13', [
		$kk->cfgFreeStarsPerPeriod(),
		GDT_Money::renderPrice($monthlyCostPerCustomer),
	]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t14');
$acc->addField(
	GDT_Paragraph::make()->text('kk_faq_b14', [
		$kk->cfgStarsPerEuro(),
	]));
echo $acc->render();

$acc = GDT_Accordeon::make();
$acc->title('kk_faq_t15');
$acc->addField(
	GDT_Paragraph::make()->text('kk_faq_b15', [
	]));
echo $acc->render();
