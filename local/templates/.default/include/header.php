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
  
  <?php Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/assets/vendor/bootstrap/css/bootstrap.min.css');?>
  <?php Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/assets/vendor/bootstrap-icons/bootstrap-icons.css');?>
  <?php Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/assets/vendor/aos/aos.css');?>
  <?php Asset::getInstance()->addCss(DEFAULT_TEMPLATE_PATH . '/assets/css/main.css');?>
  <?php Asset::getInstance()->addJs($_SERVER['DOCUMENT_ROOT'].'/local/templates/.default/assets/vendor/bootstrap/js/bootstrap.bundle.min.js');?>
  <?php Asset::getInstance()->addJs('/local/templates/.default/assets/vendor/aos/aos.js');?>
  <?php Asset::getInstance()->addJs('/local/templates/.default/assets/js/main.js');?>
	<?php $APPLICATION->ShowHead();?>
	
	

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
		"MAX_LEVEL" => "4",
		"MENU_CACHE_GET_VARS" => [
		],
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "N",
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
  <main>

<?php 
    if ($currentPath != '/') { ?>
        <!-- Page Title -->
        <div class="page-title dark-background">
          <div class="container position-relative">
            <h1><?$APPLICATION->ShowTitle(false);?></h1>
            <p><?=$APPLICATION->ShowProperty('page_text_under_title');?></p>
            <nav class="breadcrumbs">
              
							<?$APPLICATION->IncludeComponent(
								"bitrix:breadcrumb", 
								"bread-dev", 
								[
									"PATH" => "",
									"SITE_ID" => "s1",
									"START_FROM" => "0"
								],
								false
							);?>

            </nav>
          </div>
        </div><!-- End Page Title -->

         
    <?php            
    }  