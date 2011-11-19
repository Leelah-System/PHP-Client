<?php

include_once('../config/config.inc.php');
include_once(ROOT_PATH."htdocs/init.inc.php");

$oTemplate->module = 'index';
$aTpl = array();

$aTpl['login_false'] = false;

if (isset($_POST['disconnect'])) {
  session_destroy();
  session_start();
  $_SESSION['user'] = false;
 }
elseif (isset($_POST['connection_login'])) {
  $oRest = new RestAPI(LOGIN_API, PASSWORD_API);
  $oResponse = $oRest->createRequest('/api/authenticate/',
			"POST",
			array("login" => $_POST['connection_login'],
			      "password" => $_POST['connection_password']));
  if (isset($oResponse->success) && $oResponse->success == true) {
    $_SESSION['token'] = $oResponse->result->user->token;
    $_SESSION['login'] = $oResponse->result->user->login;
    $_SESSION['status'] = $oResponse->result->user->status;
  } else {
    $aTpl['login_false'] = true;
  }
 }

$oTemplate->load('header');
if (isset($_SESSION['token']) && $_SESSION['token'] != false)
  $oTemplate->loadTemplate('home', $aTpl);
 else
   $oTemplate->loadTemplate('connection', $aTpl);
$oTemplate->loadTemplate('footer');

unset($oTemplate);

?>