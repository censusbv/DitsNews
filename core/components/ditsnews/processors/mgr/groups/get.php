<?php

$groupId = (int) $_REQUEST['id'];

$group = $modx->getObject('dnGroup', $groupId);

if ($group == null) {
	return $modx->error->failure('Group not found');
}

$groupArray = $group->toArray();

return $modx->error->success('', $groupArray);