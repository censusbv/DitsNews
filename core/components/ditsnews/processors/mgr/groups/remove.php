<?php
$groupId = (int) $_REQUEST['groupId'];

$group = $modx->getObject('dnGroup', $groupId);

if ($group == null) {
	return $modx->error->failure('Group not found');
}

// Remove group
$group->remove();

return $modx->error->success('');