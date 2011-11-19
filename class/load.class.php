<?php

function __autoload($className) {
  echo ROOT_PATH.'class/' . strtolower($className) . '.class.php<br />';
  if (class_exists(ROOT_PATH.'class/' . strtolower($className))) {
      require_once(strtolower($className) . '.class.php');
    }
    throw new Exception("Can not load class : $className.");
  }

?>

