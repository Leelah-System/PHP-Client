<?php
/*
**restapi.class.php for  in /Users/Lith/Dropbox/etna/pasque_a/rendu/EIP/sources/client-web/trunk
**
**Made by Vanessa Pasque
**Login   <pasque_a@etna-alternance.net>
**
**Started on  Tue Sep 20 21:49:33 2011 Vanessa Pasque
**Last update Sat Sep 24 01:42:42 2011 Vanessa Pasque
*/

include_once("httprequest.class.php");

class RestAPI {

  private $_username;
  private $_password;
  private $_oResponse;
  private $_oRequest;
  private $_bodyResponse;
  private $_currentURL;

  function __construct($username, $password) {
    $this->_username = $username;
    $this->_password = $password;
    return true;
  }

  public function createRequest($url, $method = "POST", $arguments) {
    $oResponse = new HttpRequest($url, $method, $arguments);
    return $oResponse->getResponse();
  }

}

?>