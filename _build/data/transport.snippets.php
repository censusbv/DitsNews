<?php
$snippets = array();

$snippets[0] = $modx->newObject('modSnippet');
$snippets[0]->set('id', 0);
$snippets[0]->set('name', 'ditsnewsconfirm');
$snippets[0]->set('description', 'Confirm (opt-in) newsletter subscription');
$snippets[0]->set('snippet', file_get_contents($sources['source_core'].'/elements/snippets/ditsnewsconfirm.snippet.php'));

$snippets[1] = $modx->newObject('modSnippet');
$snippets[1]->set('id', 0);
$snippets[1]->set('name', 'ditsnewsPlaceholders');
$snippets[1]->set('description', 'Use this snippet in your newsletter template to convert placeholders');
$snippets[1]->set('snippet', file_get_contents($sources['source_core'].'/elements/snippets/ditsnewsplaceholders.snippet.php'));

$snippets[2] = $modx->newObject('modSnippet');
$snippets[2]->set('id', 0);
$snippets[2]->set('name', 'ditsnewssignup');
$snippets[2]->set('description', 'Add newsletter subscriber (or return error)');
$snippets[2]->set('snippet', file_get_contents($sources['source_core'].'/elements/snippets/ditsnewssignup.snippet.php'));

$snippets[3] = $modx->newObject('modSnippet');
$snippets[3]->set('id', 0);
$snippets[3]->set('name', 'ditsnewsunsubscribe');
$snippets[3]->set('description', 'Removes subscriber');
$snippets[3]->set('snippet', file_get_contents($sources['source_core'].'/elements/snippets/ditsnewsunsubscribe.snippet.php'));