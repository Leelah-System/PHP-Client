<?php

global $oTemplate;
global $error;
global $warning;

//$aTpl['flags'] = $oTemplate->getLangs();
$aTpl['lang'] = $oTemplate->getLang();


////////////////////////////////////////////////////
// load the css style of the module, if it exist. //
////////////////////////////////////////////////////
if (file_exists($oTemplate->getTheme().'/css/'.$oTemplate->module.".css"))
  $aTpl['style'] = $oTemplate->module;

if (file_exists(ROOT_PATH.'htdocs/libs/js/'.$oTemplate->module.".js"))
  $aTpl['script'] = $oTemplate->module;

// if the user session exist, get the user names
if (isset($_SESSION['user_id']))
  {
    $oUser = new User($_SESSION['user_id']);
    $aTpl['firstname'] = ucwords($oUser->firstname);
    $aTpl['lastname'] = ucwords($oUser->lastname);
  }

if (isset($error))
  $aTpl['error'] = intval($error);
if (isset($warning))
  $aTpl['warning'] = intval($warning);

//$aTpl['debug_msg'] = DEBUG_MSG;

$oTemplate->loadTemplate('header', $aTpl);

unset($oUser);


?>
