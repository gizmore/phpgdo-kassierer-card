<?php
namespace GDO\KassiererCard\thm\kkorg\Core\tpl\page;

use GDO\User\GDO_User;

?>
<h2><?=sitename()?></h2>
<p><?=t('responsible_is')?></p>
<?php
foreach (GDO_User::staff() as $admin)
{
	echo $admin->renderCard();
}
?>
<hr/>
<pre>
Special thanks go to `accord` from libera chat #design.
He motivated me to use SVG and did the prototype card design in 5 minutes :)
</pre>
