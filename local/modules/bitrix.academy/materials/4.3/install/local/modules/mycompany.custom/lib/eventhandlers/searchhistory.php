<?php

namespace MyCompany\Custom\EventHandlers;

use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\Entity\Event;

class SearchHistory
{
	public static function saveQuerySearchInfo(Event $event): EventResult
	{
		return new EventResult();
	}
}