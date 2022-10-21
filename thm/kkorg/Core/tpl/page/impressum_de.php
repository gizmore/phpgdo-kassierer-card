<?php
namespace GDO\KassiererCard\thm\kkorg\Core\tpl\page;
use GDO\User\GDO_User;
?>
<h2><?=Sitename()?></h2>
<p><?=t('verantwortlich_ist')?></p>
<?php
foreach (GDO_User::staff() as $admin)
{
	echo $admin->renderCard();
}
?>
<hr/>
<pre>
Besonderer Dank geht an `accord` vom libera chat #design.
Er hat mich motiviert, SVG zu verwenden, und das Prototyp-Kartendesign in 5 Minuten erstellt :)
</pre>
