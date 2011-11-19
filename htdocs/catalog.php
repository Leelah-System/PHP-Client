<?php

include_once('../config/config.inc.php');
include_once(ROOT_PATH."htdocs/init.inc.php");

$oTemplate->module = 'catalog';

$oTemplate->load('header');
$oTemplate->loadTemplate('catalog');
$oTemplate->loadTemplate('footer');

unset($oTemplate);

?>