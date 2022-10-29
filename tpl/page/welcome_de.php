<?php
namespace GDO\KassiererCard\tpl\page;
use GDO\UI\GDT_Link;
use GDO\UI\GDT_Divider;
use GDO\KassiererCard\KC_Coupon;
use GDO\UI\GDT_Container;
?>
<h2>Hallo und herzlich Willkommen auf <?=sitename()?></h2>
<p>Ich möchte mich kurz vorstellen.<br/>
Ich heisse Christian, oder auch <?=profile_link('gizmore')?>, bin ca. 42 Jahre alt, und bin ein Programmierer aus Peine.
</p>
<p>
</p>
<?php
$coupon = KC_Coupon::demoCoupon();
$cont = GDT_Container::make();
$cont->addFields(
	$coupon->getFrontSide()->css('max-width', '320px'),
	$coupon->getBackSide()->css('max-width', '320px'),
);
echo $cont->render();
?>
<p>Ihr alle kennt:</p>
<ul>
<li><a href="https://www.payback.de/" rel="nofollow">Payback Card</a></li>
<li><a href="https://www.deutschlandcard.de/" rel="nofollow">Deutschland Card</a></li>
<li>ARAL-Card</li>
<li>OBI-Card?</li>
</ul>
<p>Und viele mehr...</p>

<p>Was haben alle diese Systeme gemeinsam?</p>
<p>Richtig; es geht immer nur um die Kunden.<br/>
Niemals denkt jemand an die Arbeiter.
Die Kassierer, die Fahrer, das Reinigungspersonal,
und sogar einige Manager.</p>

<p>Hier kommt <a href="//kassierercard.org">KassiererCard.org</a> ins Spiel.
Unser Bonusprogramm ist darauf ausgerichtet, den Menschen zu helfen, die das Geschäft am Laufen halten,
oft für einen Mindestlohn.</p>

<p>Wenn Sie Ihren Mitarbeitern vor Ort helfen möchten,
<?=GDT_Link::anchor(href('Register','Form'), t('btn_register'))?>
und gib ihnen Ehre, wem Ehre gebührt.</p>
<p>In der linken Seitenleiste finden Sie öffentliche Funktionen,
die rechte Seitenleiste enthält private und individuelle Funktionen.<br/>
Um sich als Kassierer oder Firma anzumelden, benötigen Sie einen speziellen Signup-Code.<br/>
Wenn Sie sich
<?=GDT_Link::anchor(href('Register', 'Form'), t('register_as_customer'))?>,
können Sie alle 2 Tage einen Gutschein erzeugen,
und diesen z.B an der Kasse bei Ihrem Kassierer abgeben.
</p>
<?=GDT_Divider::make()->render()?>
<p>Bitte beachten Sie, dass dieses Projekt noch am Anfang steht.</p>
<p>Die Website wird bis zum 9. November 2022 regelmäßig gelöscht und neu gestartet.<br/>
Ab dann starten wir in die 2. Phase.</p>
<p>Dieses Projekt ist Open Source, aber nicht kostenlos.<br/>
Der <a href="https://github.com/gizmore/phpgdo-kassierer-card">Quellcode von <?=sitename()?></a>
ist einsehbar, aber es ist unser Eigentum.<br/>
Sie können allerdings etwas beitragen.
<p>Wir suchen auch Partner!</p>
<p><em>©2022-23 - KassiererCard.org</em></p>
