<?php
namespace GDO\KassiererCard\tpl\page;

use GDO\Mail\Module_Mail;
use GDO\User\GDO_User;
use GDO\Util\Strings;

global $listed;
$listed = [];
function teamMembersInfo(string $group, array $users): string
{
	global $listed;
	$i = 0;
	$pre = '';
	foreach ($users as $user)
	{
		if (!in_array($user, $listed, true))
		{
			$pre .= teamMemberInfo($user);
			$listed[] = $user;
			$i++;
		}
	}
	$back = '';
	$back .= '<h3>' . t("the_{$group}") . "</h3>\n";
	$back .= '<p>' . t("the_{$group}_paragraph", [$i]) . "</p>\n";
	$back .= $pre;
	return $back;
}

function teamMemberInfo(GDO_User $user)
{
	return
		'<pre>' .
		Strings::shrinkHTML($user->renderProfileLink()) .
		Module_Mail::displayMailLink($user) .
		"</pre>\n";
}

?>
<h2><?=t('the_team')?></h2>
<hr/>
<?php
$info = teamMembersInfo('admins', GDO_User::admins());
$info .= teamMembersInfo('staff', GDO_User::staff());
$info .= teamMembersInfo('managers', GDO_User::withPermission('kk_manager'));
$info .= teamMembersInfo('distributors', GDO_User::withPermission('kk_distributor'));
?>
<p><?=t('the_team_paragraph', [count($listed)])?></p>
<?=$info?>
