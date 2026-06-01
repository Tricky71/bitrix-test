<?php $APPLICATION->includeComponent(
	"bitrix:menu",
	"toolbar",
	[
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "toolbar_submenu",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => "",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "toolbar",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "toolbar",
	],
	false
) ?>
