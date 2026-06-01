<?php

namespace MyCompany\Custom\EventHandlers;

use Bitrix\Iblock\ElementTable;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Localization\Loc;

class Iblock
{
	const NO_DEACTIVATE_NEWS_DAYS = 3;

	static function stopDeactivateNews(&$arFields)
	{
		global $APPLICATION;

		if ($arFields['IBLOCK_ID'] == IBLOCK_NEWS_ID && $arFields['ACTIVE'] == 'N')
		{
			$currentValues = ElementTable::getList([
				'filter' => [
					'ID' => $arFields['ID']
				],
				'select' => ['ACTIVE', 'DATE_CREATE']
			])->fetch();

			if ($currentValues['ACTIVE'] == 'Y')
			{
				/**@var DateTime $createdDate */
				$createdDate = $currentValues['DATE_CREATE'];
				$currentDate = new DateTime();
				$diffDateTime = $currentDate->getDiff($createdDate);

				if ($diffDateTime->d < static::NO_DEACTIVATE_NEWS_DAYS)
				{
					$APPLICATION->ThrowException(Loc::getMessage('MY_COMPANY_CUSTOM_NO_DEACTIVATE_NEWS_DAYS', [
						'#NO_DEACTIVATE_NEWS_DAYS#' => static::NO_DEACTIVATE_NEWS_DAYS,
						'#DAYS_LEFT#' => $diffDateTime->d,
					]));
					return false;
				}
			}
		}
	}
}