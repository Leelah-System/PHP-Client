<?php
/*
**httprequest.class.php for  in /Users/Lith/Dropbox/etna/pasque_a/rendu/EIP/sources/client-web/trunk/htdocs
**
**Made by Vanessa Pasque
**Login   <pasque_a@etna-alternance.net>
**
**Started on  Sat Sep 24 00:05:11 2011 Vanessa Pasque
**Last update Sat Sep 24 14:39:44 2011 Vanessa Pasque
*/

class HttpRequest {

  private $_host;
  private $_port;
  private $_method;
  private $_path;
  private $_params;

  private $_socket;
  private $_result;

  function __construct($path, $method, $params) {
    $this->_host = API_HOST;
    $this->_port = API_PORT;
    $this->_method = $method;
    $this->_path = $path;
    $this->connect();
    $this->assignMethod($params);
    $this->genResponse();
    $this->disconnect();
    return $this->_result;
  }

  function connect() {
    $this->_socket = curl_init();
    curl_setopt($this->_socket, CURLOPT_URL, "http://" . $this->_host . ":" . $this->_port . $this->_path);
    curl_setopt($this->_socket,CURLOPT_HTTPHEADER,
		array ("Accept: application/json"));
    curl_setopt($this->_socket, CURLOPT_RETURNTRANSFER, 1);
  }

  private function createGetMessage($aArguments) {
    foreach ($aArguments as $key => $argument) {
      $this->_params .= $argument . "=" . urlencode($key) . "&";
    }
  }

  private function assignMethod($params) {
    switch ($this->_method) {
    case 'GET':
      break;
    case 'POST':
      curl_setopt($this->_socket, CURLOPT_POST, count($params));
      curl_setopt($this->_socket, CURLOPT_POSTFIELDS, $params);
      break;
    case 'DELETE':
      curl_setopt($this->_socket, CURLOPT_CUSTOMREQUEST, "DELETE");
      break;
    }
  }

  private function disconnect() {
    curl_close($this->_socket);
  }

  private function genResponse() {
    $this->_result = curl_exec($this->_socket);
  }

  public function getResponse() {
    return json_decode($this->_result);
  }

}

?>
