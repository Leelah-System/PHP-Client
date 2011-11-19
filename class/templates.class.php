<?php
/*
**templates.class.php for  in /home/lith/Dropbox/etna/pasque_a/rendu/EIP/sources/client-web/trunk/class
**
**Made by Vanessa Pasque
**Login   <pasque_a@etna-alternance.net>
**
**Started on  Tue Sep 20 18:05:24 2011 Vanessa Pasque
**Last update Tue Sep 20 18:17:48 2011 Vanessa Pasque
*/

class Templates extends Theme {

  protected $_oSmarty;
  public $module;
  public $metacat;

  function __construct() {
    parent::__construct();
    $this->_oSmarty = new Smarty();
    $this->_oSmarty->clearCompiledTemplate();
    $this->_oSmarty->template_dir = ROOT_PATH.'htdocs/themes/';
    $this->_oSmarty->compile_dir = ROOT_PATH.'cache/smarty/templates_c/';
    $this->_oSmarty->cache_dir = ROOT_PATH.'cache/smarty/cache';
    $this->_oSmarty->config_dir = ROOT_PATH.'langs/'.$this->getLang().'/';
    if (DEBUG != TRUE) $this->_oSmarty->loadFilter('output','trimwhitespace');
    $this->_oSmarty->caching = false;
    $this->_oSmarty->error_reporting = ERROR_REPORTING;
    $this->metacat = '';
    //$this->_oSmarty->testInstall();
  }

  function __destruct() {
    unset($this->_oSmarty);
  }

  public function loadTemplate($template, $array = NULL, $type = CONTENT) {
    if ($array != NULL)
      foreach ($array as $key => $value) {
        $this->_oSmarty->assign($key, $value);
      }
    if (!is_null($this->module))
      $this->_oSmarty->assign('module', $this->module);
    if (!is_null($this->module))
      $this->_oSmarty->assign('metacat', $this->module.$this->metacat);
    $this->_oSmarty->assign('theme_dir', '/themes/'.$this->getTheme());
    $this->_oSmarty->assign('THEME', $this->getTheme());
    $this->_oSmarty->assign('DEBUG', DEBUG);
    $this->_oSmarty->assign('HOST', 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '').'://'.HOST.(NOLANG === TRUE ? '' : '/'.$this->getLang()));
    $this->_oSmarty->assign('MASTER_HOST', 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '').'://'.MASTER_HOST.(NOLANG === TRUE ? '' : '/'.$this->getLang()));
    $this->_oSmarty->assign('IMG_HOST', 'http://'.IMG_HOST);
    $this->_oSmarty->assign('HOST_NOSSL', 'http://'.HOST.(NOLANG === TRUE ? '' : '/'.$this->getLang()));
    $this->_oSmarty->assign('HOST_SSL', 'https://'.HOST.(NOLANG === TRUE ? '' : '/'.$this->getLang()));
    $this->_oSmarty->assign('LANG', $this->getLang());
    //    $this->_oSmarty->assign('MONEY', $this->getMoney());
    $template = $this->getTheme().'/templates/'.$template;
    if ($this->_oSmarty->templateExists($template.'-'.$this->getLang().'.tpl'))
      $content = $this->_oSmarty->fetch($template.'-'.$this->getLang().'.tpl');
    else
      $content = $this->_oSmarty->fetch($template.'.tpl');
    if ($type == CONTENT)
      echo $content;
    elseif ($type == JAVASCRIPT)
      {
        preg_match_all("/<script[^>]*>(.*)<\/script>/Uis", $content, $out);
        echo $out[1][0];
      }
    $this->_oSmarty->clearAllAssign();

  }

  public function getThemes() {
    $listThemes  = array();
    $path = ROOT_PATH.'htdocs/themes/';
    if ( is_dir($path) and is_readable($path) ) {
      $directory = opendir($path);
      if ( !$directory ) throw new MyException('Can\'t open the theme dir');
      while ( ($file = readdir($directory)) !== false ) {
        if ( (is_dir($path.$file)) and ($file[0] != '.') ) $listThemes[] = $file;
      }
      closedir($path);
    } else throw new MyException('Can\'t list the theme dir');
    return $listThemes;
  }

  public function getThemesMail() {
    $listThemes  = array();
    $path = ROOT_PATH.'htdocs/templates/mails/';
    if ( is_dir($path) and is_readable($path) ) {
      $directory = opendir($path);
      if ( !$directory ) throw new MyException('Can\'t open the theme dir');
      while ( ($file = readdir($directory)) !== false ) {
        if ( (is_dir($path.$file)) and ($file[0] != '.') ) $listThemes[] = $file;
      }
      closedir($path);
    } else throw new MyException('Can\'t list the theme dir');
    return $listThemes;
  }

  public function getFilesForTheme($theme, $type = 'theme', $directory = NULL) {
    $themeFiles = array();

    if ( !is_null($directory) ) $directory_in = $directory.'';
    else $directory_in = '';

    if ($type == 'mail')
      $path = ROOT_PATH.'htdocs/templates/mails/'.$theme.'/'.$directory_in;
    else
      $path = ROOT_PATH.'htdocs/themes/'.$theme.'/'.$directory_in;

    if (!is_dir($path))
      throw new MyException('The theme folder is not a dir');

    $dir_handle = opendir($path);
    if (!$dir_handle)
      throw new MyException('Dir handle can\'t be created');

    $i = 0;
    while (($file = readdir($dir_handle)) !== false) {
      if (($file[0] != '.') && (is_file($path.$file)) && (preg_match('`-save.tpl`i', $file) == 0)) {
        $decoup = explode('.', $file);
        if (count($decoup) == 2 && $decoup[1] == 'tpl' ) {
          $themeFiles[$i]['file'] = $decoup[0].'.tpl';
          $themeFiles[$i++]['save'] = (is_file($path.$decoup[0].'-save.tpl') ? $decoup[0].'-save.tpl' : '');
        }
        elseif (count($decoup) == 2 && $decoup[1] == 'css' ) {
          $themeFiles[$i]['file'] = $decoup[0].'.css';
          $themeFiles[$i++]['save'] = (is_file($path.$decoup[0].'-save.css') ? $decoup[0].'-save.css' : '');
        }
      }
      elseif (($file[0] != '.') && (is_dir($path.$file))) {
        $themeFiles[$i++]['dir'] = $file;
      }
    }
    closedir($dir_handle);
    sort($themeFiles);

    return $themeFiles;
  }

  public function readTemplate($type = 'theme', $theme,  $file) {
    if (preg_match('`\.\.`', $theme) == 1)
      throw new MyException('Using two points is not allowed in theme.');
    if ((preg_match('`\.\.`', $file) == 1) || ((preg_match('`tpl$`', $file) == 0) && (preg_match('`css$`', $file) == 0)))
      throw new MyException('Forbidden caracters is finded');

    if ($type == 'theme')
      $path = ROOT_PATH.'htdocs/themes/'.$theme.'/'.$file;
    else
      $path = ROOT_PATH.'htdocs/templates/mails/'.$theme.'/'.$file;

    if (!is_file($path) || !is_readable($path))
      throw new MyException('File is not a file or is not readable');

    $content = file_get_contents($path);
    $content = htmlspecialchars_decode($content);
    return htmlentities($content, ENT_NOQUOTES, 'UTF-8');
  }

  public function getDirectoryFromFile( $file ) {
    if ( preg_match('`\.\.`', $file == 1) ) throw new MyException('Forbidden caracters is finded');

    $file_exploded = explode('/', $file);
    $number_folder = count($file_exploded) -1;
    $folder = null;
    foreach ( $file_exploded as $key => $value ) {
      if ( $key == $number_folder ) break;
      $folder .= $value.'/';
    }
    return $folder;
  }

  public function genereFile($type = 'theme', $theme, $file, $new_data) {
    if ( $type == 'theme' ) {
      $path = ROOT_PATH.'htdocs/themes/'.$theme.'/'.$file;
      $tmp = preg_replace('/.tpl$/', '', $file);
      $clearFile = ROOT_PATH.'htdocs/themes/'.$theme.'/'.$tmp.'-save.tpl';
    }
    else {
      $path = ROOT_PATH.'htdocs/templates/mails/'.$theme.'/'.$file;
      $tmp = preg_replace('/.tpl$/', '', $file);
      $clearFile = ROOT_PATH.'htdocs/templates/mails/'.$theme.'/'.$tmp.'-save.tpl';
    }

    if (!is_file($path) or !is_readable($path)) throw new MyException('File is not a file or is not readable');

    if (!strstr($path, "-save"))
      rename($path, $clearFile);
    $new_file = @fopen($path, 'w+');
    if ($new_file != false)
      {
        if (strstr($path, '-html.tpl')) {
          $new_data = str_replace('<br />', '', $new_data);
          $new_data = htmlentities($new_data, ENT_NOQUOTES, 'UTF-8');
          $new_data = htmlspecialchars_decode($new_data);
          fwrite($new_file, nl2br($new_data));
        }
        else
          fwrite($new_file, html_entity_decode($new_data, ENT_NOQUOTES, 'UTF-8'));
        fclose($new_file);
      }
  }

}

class resultTpl {
  public $file;
  public $save;
  public $dir;

  function __construct() {
  }
}

?>
