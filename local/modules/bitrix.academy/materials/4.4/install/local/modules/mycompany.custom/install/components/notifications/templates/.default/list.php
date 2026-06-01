<?php B_PROLOG_INCLUDED === true || die();

/**
 * @global CMain $APPLICATION
 * @var Notifications $component
 * @var array $arParams
 * @var array $arResult
 */

$APPLICATION->IncludeComponent(
	'mycompany.custom:notification.list',
	'',
	[
		'DETAIL_URL' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['detail'],
		'ELEMENT_COUNT' => 10,
		'CACHE_TIME' => $arParams['CACHE_TIME'],
		'CACHE_TYPE' => $arParams['CACHE_TYPE'],
	],
	$component
);
