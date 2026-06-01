<?php B_PROLOG_INCLUDED === true || die();
/**
 * @global CMain $APPLICATION
 * @global CUser $USER
 */

require_once $_SERVER["DOCUMENT_ROOT"] . "/local/templates/.default/include/header.php";
IncludeTemplateLangFile(__FILE__);
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/custom_styles.css");
CModule::IncludeModule('mycompany.custom');

$currentPage = $APPLICATION->GetCurPage();
$lastProfilePage = $APPLICATION->get_cookie('last_profile_page');
if ($currentPage !== '/personal/')
{
	$APPLICATION->set_cookie('last_profile_page', preg_replace('/^\/personal(\/.*)/', '$1', $currentPage), time() + 3600 * 24, '/personal/');
}
elseif ($lastProfilePage)
{
	$APPLICATION->set_cookie('last_profile_page', $lastProfilePage, time() - 3600, '/personal/');
	if ($_GET['personal_backurl'] === 'Y' && str_starts_with($lastProfilePage, '/'))
	{
		LocalRedirect('/personal' . $lastProfilePage);
	}
}
?>

<header class="header">
	<div class="container-lg">
		<div class="header__inner">
            <button class="header__control" type="button" data-bs-target="#SIDE_PANEL" data-bs-toggle="offcanvas"><span
                        class="header__burger"></span></button>
			<div class="header__logo">
				<div class="image image_size_157x53">
					<div class="image__inner">
						<a class="a" href="<?=SITE_DIR?>">
							<img class="img img_lazy lazyload"
									src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
									alt="image" data-src="<?=DEFAULT_TEMPLATE_PATH?>/images/logo.png">
						</a>
					</div>
				</div>
			</div>
			<?php if ($USER->IsAuthorized()):?>
				<div class="header__form">
					<?php $APPLICATION->IncludeComponent(
						"bitrix:main.user.link",
						"",
						Array(
							"CACHE_TIME" => "7200",
							"CACHE_TYPE" => "A",
							"ID" => $USER->GetID(),
							"NAME_TEMPLATE" => "",
							"SHOW_LOGIN" => "Y",
							"USE_THUMBNAIL_LIST" => "Y",
							"THUMBNAIL_LIST_SIZE" => "50"
						)
					);?>
					<div class="col-auto header__logout border-0">
						<a class="btn btn-primary rounded-5 w-auto" role="button" href="<?="?" . CUser::getLogoutParams()?>">
							<?=GetMessage('ACADEMY_PERSONAL_LOGOUT')?>
						</a>
					</div>
				</div>
			<?php endif;?>
		</div>
	</div>
    <div class="offcanvas offcanvas-start" id="SIDE_PANEL">
        <div class="offcanvas-header">
            <div class="offcanvas__btn" data-bs-dismiss="offcanvas">
                <div class="fa-solid fa-xmark"></div>
                <span class="flex-grow-1 ps-2"><?=GetMessage('ACADEMY_PERSONAL_SIDE_PANEL_CLOSE')?></span>
            </div>
        </div>
        <div class="offcanvas-body p-0">
			<?php $APPLICATION->IncludeComponent(
				"bitrix:menu",
				"mobile",
				[
					"ALLOW_MULTI_SELECT" => "N",
					"CHILD_MENU_TYPE" => "left",
					"DELAY" => "N",
					"MAX_LEVEL" => "2",
					"MENU_CACHE_GET_VARS" => "",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_TYPE" => "N",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"ROOT_MENU_TYPE" => "top",
					"USE_EXT" => "Y",
					"COMPONENT_TEMPLATE" => "main",
				],
				false
			) ?>
        </div>
        <div class="p-3 flex-grow-0 flex-shrink-1 text-center">
            <a class="btn btn-primary w-100 rounded-pill" role="button" href="tel:84952128509"><?=GetMessage('ACADEMY_PERSONAL_SIDE_PANEL_PHONE')?></a>
            <div class="mt-2 text-muted"><?=GetMessage('ACADEMY_PERSONAL_SIDE_PANEL_SCHEDULE')?></div>
        </div>
    </div>
</header>
<main class="main">
	<div class="container-lg">
		<?php $APPLICATION->IncludeComponent(
			"bitrix:breadcrumb",
			".default",
			[
				"COMPONENT_TEMPLATE" => ".default",
				"START_FROM" => "0",
				"PATH" => "",
				"SITE_ID" => "s1"
			]
		);?>
        <h1 class="mt-0 pb-xl-4"><?php $APPLICATION->ShowTitle(false)?></h1>
        <div class="mb-5 pb-4">
            <div class="row justify-content-between">
                <div class="col-12 col-lg-4 col-xl-3 d-none d-lg-block">
                    <?php $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "left",
                        [
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "2",
                            "MENU_CACHE_GET_VARS" => [
                            ],
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "ROOT_MENU_TYPE" => "top",
                            "USE_EXT" => "Y",
                            "COMPONENT_TEMPLATE" => "left"
                        ],
                        false
                    ); ?>
                </div>
                <div class="col-12 col-lg-8">