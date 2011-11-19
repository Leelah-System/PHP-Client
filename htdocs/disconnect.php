<?php

include_once('../config/config.inc.php');
include_once(ROOT_PATH."htdocs/init.inc.php");

session_destroy();
session_start();

$aTpl['login_false'] = false;

$oTemplate->module = 'index';

$oTemplate->load('header');
$oTemplate->loadTemplate('connection', $aTpl);
$oTemplate->loadTemplate('footer');

unset($oTemplate);

?>