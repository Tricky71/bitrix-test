<?php

namespace MyCompany\Custom\EventHandlers;

use Bitrix\Main\Application;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Bitrix\Main\UserTable;
use Bitrix\Main\UserGroupTable;

class Main
{
	protected static $oldGroups = [];

	static function showDetailButton(&$items)
	{
		$request = Application::getInstance()->getContext()->getRequest();
		if ('/bitrix/admin/iblock_element_edit.php' == $request->getRequestedPage() && Loader::includeModule('iblock'))
		{
			$elements = \CIblockElement::getList(
				[],
				[
					'ID' => $request->get('ID')
				],
				false,
				false,
				['ID', 'DETAIL_PAGE_URL']
			);

			if ($elem = $elements->getNext()) {
				$items[] = [
					'TEXT' => Loc::getMessage('MY_COMPANY_CUSTOM_TO_SITE_BTN'),
					'LINK' => $elem['DETAIL_PAGE_URL']
				];
			}
		}
	}

	static function fillOldGroups(&$arParams)
	{
		$groups = UserGroupTable::getList([
			'filter' => [
				'USER_ID' => $arParams['ID']
			],
			'select' => ['GROUP_ID']
		]);

		static::$oldGroups = [];

		while ($group = $groups->fetch())
		{
			static::$oldGroups[] = $group['GROUP_ID'];
		}
	}

	static function notifyAdmins(&$arParams)
	{
		$newGroups = array_column($arParams['GROUP_ID'], 'GROUP_ID');
		$isAddedToAdmin = !in_array(ADMIN_GROUP_ID, static::$oldGroups) && in_array(ADMIN_GROUP_ID, $newGroups);

		if ($isAddedToAdmin)
		{
			$rsUsers = UserTable::getList([
				'filter' => [
					'GROUP_ID' => ADMIN_GROUP_ID
				],
				'select' => ['EMAIL', 'GROUP_ID' => 'GROUPS.GROUP_ID']
			]);

			$adminEmails = [];
			while ($user = $rsUsers->fetch())
			{
				$adminEmails[] = $user['EMAIL'];
			}

			Event::send([
				'EVENT_NAME' => 'NEW_ADMIN',
				'LID' => MY_SITE_ID,
				'C_FIELDS' => [
					'NAME' => $arParams['LAST_NAME']." ".$arParams['NAME'],
					'EMAIL' => $arParams['EMAIL'],
					'EMAIL_TO' => implode(',', $adminEmails)
				]
			]);
		}
	}

	public static function changeTitleColor()
	{
		global $APPLICATION;
		$APPLICATION->SetAdditionalCSS("/bitrix/js/bitrix.academy/css/style.css");
	}
}