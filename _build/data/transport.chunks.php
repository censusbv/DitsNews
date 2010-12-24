<?php
$chunks = array();

$chunks[0] = $modx->newObject('modChunk');
$chunks[0]->set('id', 0);
$chunks[0]->set('name', 'ditsnewssignup');
$chunks[0]->set('description', 'Signup form');
$chunks[0]->set('snippet', file_get_contents($sources['source_core'].'/elements/chunks/ditsnewssignup.chunk.tpl'));

$chunks[1] = $modx->newObject('modChunk');
$chunks[1]->set('id', 0);
$chunks[1]->set('name', 'ditsnewssignupmail');
$chunks[1]->set('description', 'Confirmation message after newsletter signup');
$chunks[1]->set('snippet', file_get_contents($sources['source_core'].'/elements/chunks/ditsnewssignupmail.chunk.tpl'));