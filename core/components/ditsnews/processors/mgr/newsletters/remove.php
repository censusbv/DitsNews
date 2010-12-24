<?php
$newsletterId = (int) $_REQUEST['newsletterId'];

$newsletter = $modx->getObject('dnNewsletter', $newsletterId);

if ($newsletter == null) {
	return $modx->error->failure('Newsletter not found');
}

// Remove newsletter
$newsletter->remove();

return $modx->error->success('');