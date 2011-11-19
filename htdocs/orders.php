<?php

include_once('../config/config.inc.php');
include_once(ROOT_PATH."htdocs/init.inc.php");

$oTemplate->module = 'orders';

$oTemplate->load('header');
$oTemplate->loadTemplate('orders');
$oTemplate->loadTemplate('footer');

unset($oTemplate);

?>