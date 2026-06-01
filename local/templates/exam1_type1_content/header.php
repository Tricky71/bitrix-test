<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

require_once $_SERVER["DOCUMENT_ROOT"] . "/local/templates/.default/include/boot.php";

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

use Bitrix\Main\Application; 
$currentPath = Application::getInstance()->getContext()->getRequest()->getRequestedPageDirectory();
// debug($currentPath);
use Bitrix\Main\Page\Asset;
$asset = Asset::getInstance();
?>

<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">

<head>
	<title><?$APPLICATION->ShowTitle(false)?></title>
	
  <?php Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/assets/vendor/bootstrap/css/bootstrap.min.css');?>
  <?php Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/assets/vendor/bootstrap-icons/bootstrap-icons.css');?>
  <?php Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/assets/vendor/aos/aos.css');?>
  <?php Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/assets/css/main.css');?>
  <?php Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js');?>
  <?php Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . '/assets/vendor/aos/aos.js');?>
  <?php Asset::getInstance()->addJs(DEFAULT_TEMPLATE_PATH . '/assets/js/main.js');?>
	<?$APPLICATION->ShowHead();?>
	<!-- <meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport"> -->
	
	

	<!-- Favicons -->
	
  <?php Asset::getInstance()->addString('<link rel="icon" type="image/svg+xml" href="' . DEFAULT_TEMPLATE_PATH . '/assets/img/favicon.png">');?>
  <?php Asset::getInstance()->addString('<link rel="apple-touch-icon" type="image/svg+xml" href="' . DEFAULT_TEMPLATE_PATH . '/assets/img/apple-touch-icon.png">');?>
</head>

<body class="scrolled">
  <div id="panel"><?$APPLICATION->ShowPanel();?></div>
	<header id="header" class="header d-flex align-items-center">
		<div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

			<a href="/" class="logo d-flex align-items-center">
				<h1 class="sitename"><?=GetMessage('MAIN_LOGO')?></h1>
			</a>

			<nav id="navmenu" class="navmenu">
				<!-- <ul>
					<li><a href="#">Главная</a></li>
					<li><a href="#">Пункт 1</a></li>
					<li><a href="#">Пункт 1</a></li>
					<li><a href="#">Пункт 3</a></li>
					<li><a href="#">Пункт 4</a></li>
					<li class="dropdown">
						<a href="#"><span>Пункт 5 с подменю</span>
							<i class="bi bi-chevron-down toggle-dropdown"></i>
						</a>
						<ul>
							<li><a href="#">Пункт 1</a></li>
							<li class="dropdown"><a href="#"><span>Пункт 2 с подменю</span> <i
										class="bi bi-chevron-down toggle-dropdown"></i></a>
								<ul>
									<li><a href="#">Пункт 1</a></li>
									<li><a href="#">Пункт 2</a></li>
									<li><a href="#">Пункт 3</a></li>
								</ul>
							</li>
							<li><a href="#">Пункт 2</a></li>
							<li><a href="#">Пункт 3</a></li>
							<li><a href="#">Пункт 4</a></li>
						</ul>
					</li>
					<li><a href="#">Пункт 6</a></li>
				</ul>
				<i class="mobile-nav-toggle d-xl-none bi bi-list"></i> -->
				 <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"main-top", 
	[
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "3",
		"MENU_CACHE_GET_VARS" => [
		],
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "main-top",
		"MENU_THEME" => "site",
		"CHECK_PERMISSIONS" => "Y"
	],
	false
);?>
			</nav>

		</div>
	</header>

	<main class="main">

		<!-- Conten Page Section -->
		<section class="content-page section">

			<div class="container">
				<div class="row gy-5">

					<div class="col-lg-4">

						<div class="service-box">
							<div class="services-list">
								<?$APPLICATION->IncludeComponent(
									"bitrix:menu", 
									"main-left", 
									[
										"ALLOW_MULTI_SELECT" => "N",
										"CHILD_MENU_TYPE" => "left",
										"DELAY" => "N",
										"MAX_LEVEL" => "1",
										"MENU_CACHE_GET_VARS" => [
											0 => "",
										],
										"MENU_CACHE_TIME" => "3600",
										"MENU_CACHE_TYPE" => "Y",
										"MENU_CACHE_USE_GROUPS" => "Y",
										"MENU_THEME" => "site",
										"ROOT_MENU_TYPE" => "left",
										"CACHE_SELECTED_ITEMS" => "Y",
										"USE_EXT" => "N"
									],
									false
								);?>
							</div>
						</div>

						<div class="service-box">
							<h4>Материалы</h4>
							<div class="download-catalog">
								<a href="#"><i class="bi bi-filetype-pdf"></i><span>Скачать PDF</span></a>
								<a href="#"><i class="bi bi-file-earmark-word"></i><span>Скачать DOC</span></a>
							</div>
						</div>

						<div class="help-box d-flex flex-column justify-content-center align-items-center">
							<i class="bi bi-headset help-icon"></i>
							<h4>Вопросы?</h4>
							<p class="d-flex align-items-center mt-2 mb-0"><i class="bi bi-telephone me-2"></i> <span>+7 000
									000 00 00</span></p>
							<p class="d-flex align-items-center mt-1 mb-0"><i class="bi bi-envelope me-2"></i> <a
									href="mailto:contact@example.com">contact@company.ru</a></p>
						</div>

					</div>
          <div class="col-lg-8 ps-lg-5">
						<div class="page-content-title">
							<div class="position-relative">
								<h1><?$APPLICATION->ShowTitle(false);?></h1>
								<p><?=$APPLICATION->ShowProperty('page_text_under_title');?></p>
								<nav class="breadcrumbs">
									<!-- <ol>
										<li><a href="#">Главная</a></li>
										<li><a href="#">О компании</a></li>
									</ol> -->
									<?$APPLICATION->IncludeComponent(
										"bitrix:breadcrumb", 
										"bread-cont", 
										[
											
										],
										false
									);?>
								</nav>
							</div>
						</div>

