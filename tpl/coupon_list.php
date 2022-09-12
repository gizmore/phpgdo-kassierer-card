<?php
namespace GDO\KassiererCard\tpl;
use GDO\Table\GDT_ListItem;
use GDO\KassiererCard\KC_Coupon;
use GDO\UI\GDT_Container;
use GDO\UI\GDT_Button;
/** @var $gdo KC_Coupon **/
$li = GDT_ListItem::make()->gdo($gdo);
$li->creatorHeader();

if ($gdo->isEntered())
{
	$li->title('li_kk_coupon_entered', [
		tt($gdo->getGrantedDate()),
		$gdo->getGrantor()->renderUserName()]);
}
else
{
	$li->title('li_kk_coupon_fresh');
	$li->actions()->addField(GDT_Button::make('btn_print')
		->href(href('KassiererCard', 'PrintCoupon', "&token={$gdo->getToken()}")));
}

$content = GDT_Container::make()->vertical();
$content->addField($gdo->gdoColumn('coup_stars'));
$content->addField($gdo->gdoColumn('coup_type'));
$content->addField($gdo->gdoColumn('coup_token'));
$li->content($content);


echo $li->render();
