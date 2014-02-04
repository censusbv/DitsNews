<?php
$newsletter = $modx->getObject('dnNewsletter',  $scriptProperties['id']);
$attachment = $newsletter->get('attachment');

if ($newsletter == null) {
	return $modx->error->failure($modx->lexicon('ditsnews.newsletters.err.nf'));
}

// Remove newsletter
if($newsletter->remove()) {
	if (!empty($attachment)) {
		unlink($modx->getOption('assets_path').'components/ditsnews/attachments/'.$attachment);
	}
    return $modx->error->success('');
}
else {
    return $modx->error->failure($modx->lexicon('ditsnews.newsletters.err.remove'));
}
