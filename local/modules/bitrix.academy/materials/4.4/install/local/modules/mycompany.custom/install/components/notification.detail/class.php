<?php B_PROLOG_INCLUDED === true || die();

use Bitrix\Main\Application;
use Bitrix\Main\Text\HtmlConverter;
use Bitrix\Main\Type\DateTime;
use MyCompany\Custom\Notification\NotificationTable;

class NotificationDetail extends CBitrixComponent
{
	function onPrepareComponentParams($arParams)
	{
		$arParams['NOTIFICATION_ID'] = (int)$arParams['NOTIFICATION_ID'];
		return $arParams;
	}

	function executeComponent(): void
	{
		global $USER, $APPLICATION;

		$userId = $USER->getId();
		if ($userId <= 0)
		{
			return;
		}

		$notificationId = (int)$this->arParams['NOTIFICATION_ID'];
		if ($notificationId <= 0)
		{
			$this->process404();
			return;
		}

		$this->arResult['NOTIFICATION'] = $this->($userId, $notificationId);
		if (empty($this->arResult['NOTIFICATION']))
		{
			$this->process404();
			return;
		}

		if ($this->isSetImportantRequest())
		{
			$value = !$this->arResult['NOTIFICATION']['IS_IMPORTANT'];
			NotificationTable::update($notificationId, ['IS_IMPORTANT' => $value]);
			LocalRedirect($APPLICATION->GetCurPage());
		}

		$this->arResult['DISPLAY_VALUES'] = $this->getDisplayValues($this->arResult['NOTIFICATION']);
		$this->arResult['LIST_URL'] = htmlspecialcharsbx($this->arParams['LIST_URL']);

		$this->includeComponentTemplate();

		if (!$this->arResult['NOTIFICATION']['IS_READ'])
		{
			NotificationTable::update($notificationId, ['IS_READ' => true]);
		}

		if ($this->arResult['DISPLAY_VALUES']['TITLE'])
		{
			$APPLICATION->SetTitle($this->arResult['DISPLAY_VALUES']['TITLE']);
		}
	}

	protected function getNotification(int $userId, int $notificationId): array
	{
		if ($userId <= 0 || $notificationId <= 0)
		{
			return [];
		}

		$filter = [
			'=ID' => $notificationId,
			'=USER_ID' => $userId,
		];

		$select = [
			'ID',
			'DATE_CREATE',
			'TITLE',
			'MESSAGE',
			'USER_ID',
			'IS_READ',
			'IS_IMPORTANT',
			'FILES.ID',
			'FILES.HEIGHT',
			'FILES.WIDTH',
			'FILES.FILE_SIZE',
			'FILES.FILE_NAME',
			'FILES.ORIGINAL_NAME',
			'FILES.CONTENT_TYPE',
			'FILES.SUBDIR',
		];

		$notification = NotificationTable::getList([
			"select" => $select,
			"filter" => $filter,
		])->fetchObject();

		if (!$notification)
		{
			return [];
		}

		$result = [
			'ID' => $notification->getId(),
			'DATE_CREATE' => $notification->get('DATE_CREATE'),
			'TITLE' => $notification->get('TITLE'),
			'MESSAGE' => $notification->get('MESSAGE'),
			'USER_ID' => $notification->get('USER_ID'),
			'IS_READ' => $notification->get('IS_READ'),
			'IS_IMPORTANT' => $notification->get('IS_IMPORTANT'),
		];

		foreach ($notification->getFiles() as $file)
		{
			$result['FILES'][$file->getId()] = [
				'ID' => $file->getId(),
				'HEIGHT' => $file->get('HEIGHT'),
				'WIDTH' => $file->get('WIDTH'),
				'FILE_SIZE' => $file->get('FILE_SIZE'),
				'FILE_NAME' => $file->get('FILE_NAME'),
				'ORIGINAL_NAME' => $file->get('ORIGINAL_NAME'),
				'CONTENT_TYPE' => $file->get('CONTENT_TYPE'),
				'SUBDIR' => $file->get('SUBDIR'),
			];
		}

		return $result;
	}

	protected function getDisplayValues(array $item): array
	{
		$converter = new HtmlConverter();

		$item['DATE_CREATE'] = $item['DATE_CREATE'] instanceof DateTime
			? $item['DATE_CREATE']->toString()
			: null;

		foreach ($item as $field => $value)
		{
			if (!is_array($value))
			{
				$item[$field] = $converter->encode($value);
			}
		}

		$item['MESSAGE'] = nl2br($item['MESSAGE']);

		foreach ($item['FILES'] as $id => $file)
		{
			$item['FILES'][$id]['SRC'] = CFile::GetFileSRC($file);

			foreach ($file as $field => $value)
			{
				if (!is_array($value))
				{
					$item['FILES'][$id][$field] = $converter->encode($value);
				}
			}
		}

		return $item;
	}

	protected function isSetImportantRequest(): bool
	{
		$request = Application::getInstance()->getContext()->getRequest();
		return $request->isPost() && $request->getPost('important') == 'Y' && check_bitrix_sessid();
	}

	protected function process404()
	{
		define('ERROR_404', 'Y');
		CHTTP::setStatus('404 Not Found');

		global $APPLICATION;
		$APPLICATION->RestartWorkarea();
		require_once(Application::getDocumentRoot() . '/404.php');
	}
}
