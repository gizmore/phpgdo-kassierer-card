<?php
namespace GDO\KassiererCard\thm\kkorg\Core\tpl\page;
Verwenden Sie GDO\Benutzer\GDO_Benutzer;
?>
<h2><?=Sitename()?></h2>
<p><?=t('verantwortlich_ist')?></p>
<?php
foreach (GDO_User::staff() als $admin)
{
echo $admin->renderCard();
}
?>
<hr/>
<vor>
Besonderer Dank geht an `accord` von libera chat #design.
Er hat mich motiviert, SVG zu verwenden, und das Prototyp-Kartendesign in 5 Minuten erstellt :)
</pre>