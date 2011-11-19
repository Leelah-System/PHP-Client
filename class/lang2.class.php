<?php

class Lang {

  private $lang;
  private $oFlags;

  function __construct($autonome = NULL) {
//     $this->oFlags = $_SESSION['database']->fetchObject("SELECT `id`, `flag`, `country`, `url` FROM `lang` ORDER BY `id`");
//     $this->lang = NULL;
//     if ($autonome == NULL)
//       $this->setLang();
    echo LANGUAGE. " <br />";
    $this->lang = LANGUAGE;
  }

  private function setLang() {
      if (($this->lang = $this->checkCookie()) == NULL)
        $this->lang = (isset($_GET['lang']) ? $_GET['lang'] : LANGUAGE);
      $this->setCookie();
  }

  public function getLang() {
    return($this->lang);
  }

  public function setMoney($money_val) {
    $res = $_SESSION['database']->fetchObject("SELECT `id` FROM `money` WHERE `currency_val`='".$_SESSION['database']->clearStr($money_val)."'");
    if (!$_SESSION['user_id']) {
      $_SESSION['money'] = $money_val;
    }
    else {
      $sql = "UPDATE `users` SET `money_id` = '".$_SESSION['database']->clearStr($res[0]->id)."' WHERE `id` = '".$_SESSION['user_id']."'";
      $_SESSION['database']->executeQ($sql);
    }
  }

  public function getMoney() {
    $ret = $_SESSION['database']->fetchObject("SELECT m.`currency_val` FROM `money` m, `users` u
                                                WHERE u.`money_id` = m.`id` AND u.`id` = '".$_SESSION['user_id']."'");
    if (count($ret) == 0) {
      if ($_SESSION['money'])
        return $_SESSION['money'];
      else {
        $lang_valid = $this->checkCountry();
        $res = $_SESSION['database']->fetchObject("SELECT m.`currency_val` AS 'currency' FROM `money` m LEFT JOIN `lang_family` l ON l.`default_money_id` = m.`id` WHERE l.`flag` = LOWER('".$lang_valid."') ;");
        if (isset($res[0]->currency))
          return $res[0]->currency;
        else
          return ('EUR');
      }
    }
    return ($ret[0]->currency_val);
  }

  public function getMoneys() {
    $sql = "SELECT * FROM `money` ORDER BY `id`";
    $oMoney = $_SESSION['database']->fetchObject($sql);
    $aMoney = array();
    foreach ($oMoney as $money) {
      if ($money->currency_val == 'EUR')
        $aMoney[$money->currency_val] = strtoupper($money->money)." - ".round($money->taux_change, 2)." ".$money->currency_html;
      else
        $aMoney[$money->currency_val] = strtoupper($money->money)." - ".$money->currency_html." ".$money->taux_change." = 1 &euro;";
    }
    return $aMoney;
  }

  public function getLangs($not_all = false) {
    $aLangs = array();
    $i = 0;
    foreach ($this->oFlags as $oflag) {
      if ($not_all == true) {
        if ($this->lang != $oflag->flag) {
          $aLangs[$i] = new LittleLang;
          $aLangs[$i]->country = $oflag->country;
          $aLangs[$i]->url = $oflag->url;
          $aLangs[$i++]->flag = $oflag->flag;
        }
      } else {
        if ($oflag->flag != 'en') {
          $aLangs[$i] = new LittleLang;
          $aLangs[$i]->country = $oflag->country;
          $aLangs[$i]->url = $oflag->url;
          $aLangs[$i++]->flag = $oflag->flag;
        }
      }
    }
    return ($aLangs);
  }

  public function getOptionLangs() {
    $aLangs = array();
    $i = 0;
    foreach ($this->oFlags as $oflag)
      if ($oflag->flag != 'en')
        $aLangs[$oflag->flag] = $oflag->country;
    return ($aLangs);
  }


  private function setCookie() {
    if (!isset($_COOKIE['lang']) || $_COOKIE['lang'] != $this->lang)
      setcookie('lang', $this->lang, '2147483647', '/', HOST, FALSE, TRUE);
  }

  private function getCookie() {
    if (isset($_COOKIE['lang']))
      return ($_COOKIE['lang']);
    return (NULL);
  }

  private function checkCookie() {
    $cookie = $this->getCookie();
    return ($this->checkValidLang($cookie));
  }

  private function checkCountry() {
    $array_bot = array("bingbot", "Googlebot", "Gigabot", "msnbot", "Ezooms",
		       "MJ12bot", "Baiduspider", "ShopWiki", "Slurp", "Yahoo",
		       "MLBot", "Jyxobot", "Sogou", "Yeti", "Comodo", "ichiro",
		       "Twitterbot", "ia_archiver", "AdsBot", "findlinks", "holmes",
		       "Sosospider", "CatchBot", "StackRambler", "vik-robot",
		       "123peoplebot", "SAMSUNG-SGH", "YandexBot");

    if (HOST == 'www.'.PRE_HOST)
      foreach ($array_bot as $bot)
        if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), strtolower($bot)) !== FALSE)
          return (BOT_LANG);

    $ip_value = preg_split('/\./', $_SESSION['ip']);
    $A = $ip_value[0];
    $B = $ip_value[1];
    $C = $ip_value[2];
    $D = $ip_value[3];

    $ip = (($A*256+$B)*256+$C)*256 + $D;
    $res = $_SESSION['database']->fetchObject("SELECT LOWER(`country_code`) AS 'code' FROM `ip_group_country` WHERE `ip_start` <= ".$ip." ORDER BY `ip_start` DESC LIMIT 1;");
    return($this->checkValidLang($res[0]->code));
  }

  private function checkNav() {
    $NavLang = '';

    if (HOST == 'www.'.PRE_HOST &&
        (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "googlebot") !== FALSE ||
         strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "Yahoo") !== FALSE ||
         strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "msnbot") !== FALSE))
      return (BOT_LANG);
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
      {
        $NavLang = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $NavLang = explode(';', $NavLang[0]);
        $NavLang = explode('-', $NavLang[0]);
        $NavLang = explode('_', $NavLang[0]);
        $sql = "INSERT INTO `http_languages` (`value`, `datetime`, `user_ip`, `referer`)
                VALUES('".$_SESSION['database']->clearStr(strtolower($NavLang[0]))."', now(), '".$_SESSION['database']->clearStr($_SERVER['REMOTE_ADDR'])."', '".$_SESSION['database']->clearStr($_SERVER['HTTP_REFERER'])."')";
        $_SESSION['database']->executeQ($sql);
      }
    return($this->checkValidLang($NavLang[0]));
  }

  private function checkUri() {
    $uriLang = $_GET['lang'];
    if (($checkedLang = $this->checkValidLang($uriLang)) != NULL)
      return ($checkedLang);
    else
      return (LANGUAGE);
  }

  public function checkValidLang($lang) {
    if (strlen($lang) != 2)
      return (NULL);
    foreach ($this->oFlags as $oFlag)
      if ($oFlag->flag == $lang)
        return($oFlag->flag);
    elseif (($family = $this->checkFamilyLang($lang)) != NULL) {
      return ($family);
    }
    return (NULL);
  }

  private function checkFamilyLang($prefix) {
    $sql = "SELECT l.`flag` FROM `lang` l, lang_family f
            WHERE f.`lang_id` = l.`id` AND f.`flag` = '".$_SESSION['database']->clearStr($prefix)."'";
    $retour = $_SESSION['database']->fetchObject($sql);
    if (count($retour) != 0)
      return ($retour[0]->flag);
  }

  private function redirectLang() {
    $base = explode(".", basename($_SERVER["SCRIPT_FILENAME"]));
    $base = $base[0];
    if ($base == '')
      $base = 'index';
    $param = '';
    foreach($_GET as $key => $value)
      $param .= ($param != '' ? '&' : '').$key.'='.$value;
    foreach ($this->oFlags as $flag)
      if ($flag->flag == $this->lang) {
        $url = $flag->url;
        break;
      }
    $uri = 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '').'://'.HOST.'/'.$this->lang.'/'.$base.'.vg'.($param != '' ? '?'.$param : '');
    header('Location: '.$uri, TRUE, 301);
    exit;
  }

}

class LittleLang { public $country; public $flag; }

?>