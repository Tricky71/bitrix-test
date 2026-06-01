<?php

use MyCompany\Custom\Notification\NotificationTable;
use MyCompany\Custom\EventHandlers\Notification;
use Bitrix\Main\Entity\DataManager;

$ormEventManager = \Bitrix\Main\ORM\EventManager::getInstance();
$ormEventManager->addEventHandler(
	NotificationTable::class,
	DataManager::EVENT_ON_AFTER_UPDATE,
	[
		Notification::class,
		'clearNotificationsCache'
	]
);
