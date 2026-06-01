<?php

namespace MyCompany\Custom\EventHandlers;

use Bitrix\Main\Application;
use Bitrix\Main\Data\Cache;
use Bitrix\Main\Entity;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UserTable;
use MyCompany\Custom\Notification\NotificationTable;

class Notification
{
	protected static array $notificationToMail = [];

	static function notificationInfoCollect(Entity\Event $event): Entity\EventResult
	{
		$result = new Entity\EventResult();

		$notificationId = $event->getParameter('id');
		if (is_array($notificationId))
		{
			$notificationId = $notificationId['ID'];
		}

		if (!$notificationId)
		{
			return $result;
		}

		$notification = NotificationTable::getList([
			'select' => [
				'ID',
				'DATE_CREATE',
				'TITLE',
				'MESSAGE',
				'USER_ID',
				'IS_READ'
			],
			'filter' => [
				'=ID' => $notificationId
			]
		])->fetch();

		if (!empty($notification['IS_READ']))
		{
			return $result;
		}

		$currentDateTime = new DateTime();
		$dateDelete = $currentDateTime->format("d.m.Y H:i:s");

		$admins = UserTable::getList([
			'select' => [
				'EMAIL',
			],
			'filter' => [
				'=GROUPS.GROUP_ID' => ADMIN_GROUP_ID
			]
		]);

		$adminEmails = [];
		while ($admin = $admins->fetch())
		{
			$adminEmails[] = $admin['EMAIL'];
		}

		static::$notificationToMail[$notificationId] = [
			'NOTIFICATION_ID' => $notification['ID'],
			'NOTIFICATION_TITLE' => $notification['TITLE'],
			'NOTIFICATION_MESSAGE' => $notification['MESSAGE'],
			'DATETIME_CREATE' => $notification['DATE_CREATE'],
			'DATETIME_DELETE' => $dateDelete,
			'USER_ID' => $notification['USER_ID'],
			'EMAIL_TO' => implode(',', $adminEmails),
		];

		return $result;
	}

	static function sendMailOnDeletedNotification(Entity\Event $event): Entity\EventResult
	{
		$result = new Entity\EventResult;

		$notificationId = $event->getParameter('id');
		if (is_array($notificationId))
		{
			$notificationId = $notificationId['ID'];
		}

		if (!$notificationId)
		{
			return $result;
		}

		if (!empty(static::$notificationToMail[$notificationId]))
		{
			Event::send([
				'EVENT_NAME' => 'DELETED_NOTIFICATION',
				'LID' => MY_SITE_ID,
				'C_FIELDS' => static::$notificationToMail[$notificationId],
			]);

			unset(static::$notificationToMail[$notificationId]);
		}

		return $result;
	}
}
