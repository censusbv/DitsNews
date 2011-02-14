<?php
$modx->regClientCss($ditsnews->config['assetsUrl'].'css/mgr/style.css');
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/extensions.js');
$modx->regClientStartupScript($ditsnews->config['assetsUrl'].'js/mgr/lexicon.php');
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/ditsnews.js');
$modx->regClientStartupScript($ditsnews->config['assetsUrl'].'js/mgr/config.php');
$modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/stores.js');

switch($_REQUEST['action']) {
    case 'groups':
        $modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/page_groups.js');
        break;
    case 'subscribers':
        $modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/page_subscribers.js');
        break;
    case 'settings':
        $modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/page_settings.js');
        break;
    default:
      $modx->regClientStartupScript($ditsnews->config['jsUrl'].'mgr/page_newsletters.js');
      break;
}
return '';