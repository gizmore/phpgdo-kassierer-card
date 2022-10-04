<?php
namespace GDO\KassiererCard\tpl;
use GDO\Table\GDT_ListItem;
use GDO\KassiererCard\KC_Coupon;
use GDO\UI\GDT_Container;
use GDO\UI\GDT_Button;
use GDO\User\GDO_User;
/** @var $gdo KC_Coupon **/
$user = GDO_User::current();
$li = GDT_ListItem::make()->gdo($gdo);
$li->creatorHeader();

if ($gdo->isEntered())
{
	$li->title('li_kk_coupon_entered', [
		tt($gdo->getEntered()),
		$gdo->getEnterer()->renderUserName()]);
}
else if ($gdo->isPrinted())
{
	$li->title('li_kk_coupon_printed', [$gdo->renderPrinted()]);
	$li->actions()->addField(GDT_Button::make('btn_print')
		->href(href('KassiererCard', 'PrintCoupon', "&token={$gdo->getToken()}")));
}
else
{
	$li->title('li_kk_coupon_fresh');
	$li->actions()->addField(GDT_Button::make('btn_print')
		->href(href('KassiererCard', 'PrintCoupon', "&token={$gdo->getToken()}")));
}

$content = GDT_Container::make()->vertical();
$content->addField($gdo->gdoColumn('kc_type'));
$content->addField($gdo->gdoColumn('kc_stars'));
$content->addField($gdo->gdoColumn('kc_offer'));
$content->addField($gdo->gdoColumn('kc_token'));
$li->content($content);

if ($gdo->canPrint($user))
{
	$li->actions()->addField(GDT_Button::make('btn_print')->icon('print')
			->label('btn_print')
			->href(href('KassiererCard', 'PrintCoupon', '&token='.$gdo->getToken())));
}


echo $li->render();
