<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('main', 'OnAdminContextMenuShow', [
	'MyCompany\Custom\EventHandlers\Main',
	'showDetailButton'
]);
$eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementUpdate', [
	'MyCompany\Custom\EventHandlers\Iblock',
	'stopDeactivateNews'
]);
$eventManager->addEventHandler('main', 'OnBeforeUserUpdate', [
	'MyCompany\Custom\EventHandlers\Main',
	'fillOldGroups'
]);
$eventManager->addEventHandler('main', 'OnAfterUserUpdate', [
	'MyCompany\Custom\EventHandlers\Main',
	'notifyAdmins'
]);
$eventManager->addEventHandler('main', 'OnBeforeEndBufferContent', [
	'MyCompany\Custom\EventHandlers\Main',
	'changeTitleColor'
]);