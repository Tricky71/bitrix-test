<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

require_once $_SERVER["DOCUMENT_ROOT"] . "/local/templates/.default/include/boot.php";

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

use Bitrix\Main\Application; 
$currentPath = Application::getInstance()->getContext()->getRequest()->getRequestedPageDirectory();

use Bitrix\Main\Page\Asset;
$asset = Asset::getInstance();
?>

<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">

<head>
  <title><?$APPLICATION->ShowTitle()?></title>
  <?php Asset::getInstance()->addString('<link rel="icon" type="image/svg+xml" href="' . DEFAULT_TEMPLATE_PATH . '/assets/img/favicon.png">');?>
  <?php Asset::getInstance()->addString('<link rel="apple-touch-icon" type="image/svg+xml" href="' . DEFAULT_TEMPLATE_PATH . '/assets/img/apple-touch-icon.png">');?>

  <?php Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/vendor/bootstrap/css/bootstrap.min.css');?>
  <?php Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/vendor/bootstrap-icons/bootstrap-icons.css');?>
  <?php Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/style.css');?>
  <?php Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js');?>
  <?php Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/main.js');?>
  <?php $APPLICATION->ShowHead();?>

  <!-- Vendor CSS Files -->
  <!-- <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet"> -->

  <!-- Template Main CSS File -->
  <!-- <link href="assets/css/style.css" rel="stylesheet"> -->

</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Статистика</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
    
    <?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form", 
	"auth", 
	[
		"FORGOT_PASSWORD_URL" => "",
		"PROFILE_URL" => "/statistic_na/profile/",
		"REGISTER_URL" => "",
		"SHOW_ERRORS" => "N",
		"COMPONENT_TEMPLATE" => "auth"
	],
	false
);?>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->


  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

   

  <?$APPLICATION->IncludeComponent(
    "bitrix:menu", 
    "main-left-stat", 
    [
      "ALLOW_MULTI_SELECT" => "Y",
      "CHILD_MENU_TYPE" => "st_second",
      "DELAY" => "N",
      "MAX_LEVEL" => "2",
      "MENU_CACHE_GET_VARS" => [
      ],
      "MENU_CACHE_TIME" => "3600",
      "MENU_CACHE_TYPE" => "Y",
      "MENU_CACHE_USE_GROUPS" => "Y",
      "MENU_THEME" => "site",
      "ROOT_MENU_TYPE" => "st_first",
      "CACHE_SELECTED_ITEMS" => "Y",
      "USE_EXT" => "N",
      "COMPONENT_TEMPLATE" => "main-left-stat"
    ],
    false
  );?>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle mb-4">
      <h1><?=$APPLICATION->ShowTitle(false)?></h1>
    </div><!-- End Page Title -->

    <section class="section <?$APPLICATION->ShowProperty("page_css_class")?>">