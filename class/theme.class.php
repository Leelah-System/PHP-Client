<?php

class Theme extends Lang {

  private $theme;

  function __construct() {
//     $oTmpThemes = $_SESSION['database']->fetchObject("SELECT `name` FROM `themes`
//                                           WHERE `active` = 1;");
//     $theme = $oTmpThemes[0]->name;

//     if (is_dir(ROOT_PATH.'htdocs/themes/'.$theme))
//       $this->theme = $theme;
//     else
    $this->theme = THEME;
    parent::__construct();
  }

  public function getTheme() {
    return ($this->theme);
  }

  public function load($script) {
    $lang = $this->getLang();
    $file = $this->theme.'/scripts/'.$script;
    if (file_exists($file.'-'.$lang.'.php'))
      include_once($file.'-'.$lang.'.php');
    else
      include_once($file.'.php');
  }

}

?>