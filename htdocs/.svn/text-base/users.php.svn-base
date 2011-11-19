<?php

include_once('../config/config.inc.php');
include_once(ROOT_PATH."htdocs/init.inc.php");

$oTemplate->module = 'users';

$oRest = new RestAPI(LOGIN_API, PASSWORD_API);

$oResponse = $oRest->createRequest('/api/users',
				    "GET",
				   array());

if (isset($oResponse->success) && $oResponse->success == true) {
  $aTpl['users'] = $oResponse->result->users;
 } else {
  $aTpl['message'] = $oResponse->msg;
 }

$oTemplate->load('header');
$oTemplate->loadTemplate('users', $aTpl);
$oTemplate->loadTemplate('footer');

unset($oTemplate);

?>