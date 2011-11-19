{config_load file="lang"}
{if !$DEBUG}{assign var=GZ value="_compressed"}{else}{assign var=GZ value=""}{/if}
<html>
  <head>
    <title>Leelah System</title>

        <meta name="description" content="{#description#}" />
        <meta name="keywords" content="{#gKeywords#}, {#keywords#}" />
        <meta http-equiv="Content-Type" content="{#ContentType#}" />
        <meta name="robots" content="index,follow" />
        <meta http-equiv="content-language" content="{#lang#}" />

        <link rel="bookmark" href="/index.php" title="{#accueil#}" />
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
	<link rel="icon" type="image/png" href="favicon.png" />

        <link rel="stylesheet" type="text/css" href="{$HOST}/css1/style.css,{$style}{$GZ}.css"/>

  </head>
  <body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="index.php">Leelah<span class="logo_colour">System</span></a></h1>
          <h2>Syst&egrave;me de gestion d'entreprise et de restaurant.</h2>
        </div>
	{if isset($smarty.session.token)}
	<div style="float:right;margin-top:100px;margin-left:20px;">
	  <form method="post" action="index.php">
	    <input type="submit" value="{#disconnect#}" name="disconnect" />
	  </form>
	</div>
	<div style="float:right;margin-top:100px;"><h4>{#welcome#} {$smarty.session.login}</h4></div>
	<div class="clearBoth" ></div>
	{/if}
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
	  {if isset($smarty.session.token)}
          <li {if $module == "index"}class="selected"{/if}><a href="index.php">Home</a></li>
          <li {if $module == "catalog"}class="selected"{/if}><a href="catalog.php">Catalogue</a></li>
          <li {if $module == "products"}class="selected"{/if}><a href="products.php">Produits</a></li>
          <li {if $module == "orders"}class="selected"{/if}><a href="orders.php">Commandes</a></li>
          <li {if $module == "users"}class="selected"{/if}><a href="users.php">Utilisateurs</a></li>
          <li {if $module == "reports"}class="selected"{/if}><a href="reports.php">Rapport</a></li>
	  {else}
          <li class="selected"><a href="index.php">Home</a></li>
	  {/if}
        </ul>
      </div>
    </div>
    <div id="content_header"></div>
    <div id="site_content">

