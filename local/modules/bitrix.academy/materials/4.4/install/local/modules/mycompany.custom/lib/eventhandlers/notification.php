<?php

namespace MyCompany\Custom\EventHandlers;

use Bitrix\Main\Entity;

class Notification
{
	static function prohibitAddingReadNotifications(Entity\Event $event): Entity\EventResult
	{
		$result = new Entity\EventResult();

		global $USER;
		if ($USER->isAdmin())
		{
			return $result;
		}

		$result->modifyFields(['IS_READ' => false]);
		return $result;
	}
}
