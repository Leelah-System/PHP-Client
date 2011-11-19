<?php

include_once('../config/config.inc.php');
include_once(ROOT_PATH."htdocs/init.inc.php");

$oTemplate->module = 'products';
$oRest = new RestAPI(LOGIN_API, PASSWORD_API);

if (isset($_POST['add_product'])) {
  $tpl = "addproduct";
 }
 else {
   $tpl = "products";
 }

if (isset($_POST['delete'])) {
  $oResponse = $oRest->createRequest('/api/'.$_SESSION['token'].'/product/' . $_POST['id'],
				     "DELETE",
				     array());
  $aTpl['message'] = $oResponse->msg;
 }
elseif (isset($_POST['add_this_product'])) {
  $line = "product[name]=" . $_POST['name'] . "&" ;
  $line .= "product[description]=".$_POST['description'] . "&";
  $line .= "product[price]=".$_POST['price']. "&";
  $line .= "product[stocks]=".$_POST['stocks'];
  $oResponse = $oRest->createRequest('/api/'.$_SESSION['token'].'/product',
				     "POST",
				     $line);
  //  bt($oResponse);
  $aTpl['product'] = $_POST;
  $aTpl['message'] = $oResponse->msg;
  $tpl = "addproduct";
}

$oResponse = $oRest->createRequest('/api/'.$_SESSION['token'].'/product',
				   "GET",
				   array());

if (isset($oResponse->success) && $oResponse->success == true) {
  $aTpl['products'] = $oResponse->result->products;
 } else {
  $aTpl['login_false'] = true;
  }

$oTemplate->load('header');
$oTemplate->loadTemplate($tpl, $aTpl);
$oTemplate->loadTemplate('footer');

unset($oTemplate);

?>