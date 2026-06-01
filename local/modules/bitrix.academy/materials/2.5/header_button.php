<?php $APPLICATION->IncludeComponent(
	"bitrix:main.auth.form",
	"header",
	[
		"AUTH_FORGOT_PASSWORD_URL" => "",
		"AUTH_REGISTER_URL" => "",
		"AUTH_SUCCESS_URL" => "",
		"COMPONENT_TEMPLATE" => "header",
		"AUTH_PAGE" => "/login/",
		"PERSONAL_PAGE" => "/personal/"
	],
	false
);?>