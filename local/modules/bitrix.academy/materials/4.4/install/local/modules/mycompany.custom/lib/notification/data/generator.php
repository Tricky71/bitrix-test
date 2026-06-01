<?php

namespace MyCompany\Custom\Notification\Data;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\IO\File;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UserTable;
use CFile;
use Exception;
use MyCompany\Custom\Notification\NotificationFileTable;
use MyCompany\Custom\Notification\NotificationTable;

class Generator
{
	protected const DEFAULT_FILE_DIR = '/local/modules/mycompany.custom/install/files/notification';

	protected array $fileIdsCache = [];

	/**
	 * @throws ArgumentException
	 * @throws Exception
	 */
	function generateCount(int $count, ?string $fileDir = null, ?int $userId = null): void
	{
		if ($count <= 0)
		{
			return;
		}

		if (!$fileDir)
		{
			$fileDir = Application::getDocumentRoot() . static::DEFAULT_FILE_DIR;
		}

		if (!is_dir($fileDir))
		{
			throw new ArgumentException("Incorrect file directory [$fileDir]");
		}

		$testItems = $this->getTestItems();
		$countItems = count($testItems);
		$countUsers = 1;
		$userIds = [];

		if (is_null($userId))
		{
			$userIds = UserTable::getList([
				'order' => ['ID' => 'ASC'],
				'select' => ['ID'],
				'limit' => $countItems,
			])->fetchAll();

			$userIds = array_column($userIds, 'ID');
			$countUsers = count($userIds);
		}
		elseif ($userId <= 0)
		{
			throw new ArgumentException("Incorrect User ID [$userId] given");
		}
		else
		{
			$user = UserTable::getById($userId)->fetch();
			if (!$user)
			{
				throw new ArgumentException("User [$userId] not exist");
			}

			$userIds[] = $userId;
		}

		$fileDir = rtrim($fileDir, '/') . '/';
		$dateCreateMinTimestamp = (new DateTime('01.01.2023'))->getTimestamp();
		$dateCreateMaxTimestamp = (new DateTime('01.04.2024'))->getTimestamp();

		for ($i = 1; $i <= $count; $i++)
		{
			$fields = current($testItems);
			$files = $fields['FILES'];
			unset($fields['FILES']);

			$fields['USER_ID'] = current($userIds);

			$randTimestamp = rand($dateCreateMinTimestamp, $dateCreateMaxTimestamp);
			$fields['DATE_CREATE'] = DateTime::createFromTimestamp($randTimestamp);

			$result = NotificationTable::add($fields);
			if (!$result->isSuccess()) {
				throw new GeneratorException('Failed to add notification: ' . implode(',', $result->getErrorMessages()));
			}

			if (!next($testItems))
			{
				reset($testItems);

				if ($countUsers > 1 && !next($userIds))
				{
					reset($userIds);
				}
			}

			if (!$files) {
				continue;
			}

			foreach ($files as $name)
			{
				$fileId = $this->fileIdsCache[$name];
				if (!$fileId)
				{
					if (!File::isFileExists($fileDir . $name))
					{
						continue;
					}

					$fileArray = CFile::MakeFileArray($fileDir . $name);
					$fileId = CFile::SaveFile($fileArray, 'notifications');
					if (!$fileId)
					{
						continue;
					}
				}

				NotificationFileTable::add([
					'NOTIFICATION_ID' => $result->getId(),
					'FILE_ID' => $fileId,
				]);

				$this->fileIdsCache[$name] = $fileId;
			}
		}
	}


	protected function getTestItems(): array
	{
		return [
			[
				'TITLE' => 'Новая поставка мебели уже на складе',
				'MESSAGE' => "Поступила партия мебели по заказу №255739.\nСрок хранения - 2 недели.\nАдрес склада: ул. Новосельская, д. 144к3",
			],
			[
				'TITLE' => 'Заявки из формы обратной связи ждут рассмотрения',
				'MESSAGE' => "137 заявок из Формы обратной связи ожидают обработки.\nСрок рассмотрения заявки - не более одного месяца с момента ее подачи.",
			],
			[
				'TITLE' => 'Напоминание о встрече',
				'MESSAGE' => "Напоминание об участии во встрече в 15:00.\nТема: Изменения в процедуре приема товаров.\nЕсли Вы не сможете присутствовать на ней, просьба заранее сообщить об этом руководителю Вашего отдела.",
			],
			[
				'TITLE' => 'Товар "Диван угловой тканевый Мускари" на складе заканчивается',
				'MESSAGE' => 'Товар "Диван угловой тканевый Мускари" скоро закончится. Остаток - 5 шт.',
				'FILES' => [
					'Диван угловой тканевый Мускари.png',
					'Характеристики товара (Мускари).docx',
				],
			],
			[
				'TITLE' => 'Приближение срока планового обновления каталога мебели',
				'MESSAGE' => "Напоминаем, что в следующем месяце запланировано обновление каталога мебели. По всем связанным предложениям обращаться к руководителю.",
			],
			[
				'TITLE' => 'Срок выполнения заказа №3892382 на исходе',
				'MESSAGE' => "Просьба обратить внимание, что близится дата завершения по заказу №3892382.\nДля своевременного его выполнения необходимо уточнить его статус и принять меры для ускорения обработки.",
			],
			[
				'TITLE' => 'Изменение графика работы в связи с праздничными днями',
				'MESSAGE' => "В связи с приближающимися праздниками изменен график работы на ближайшие дни:\n чт. с 9-00 до 16-00\nпт. Выходной",
			],
			[
				'TITLE' => 'Сбор заявок на обновление оборудования',
				'MESSAGE' => "Открывается сбор заявок на обновление рабочего оборудования. Заявки принимаются руководителями отделов на электронную почту.\nСрок - до конца недели.\n\nШаблон во вложении.",
				'FILES' => [
					'Шаблон заявления.docx',
				],
			],
			[
				'TITLE' => 'Товар "Кровать Белла 160*200 велюр Monolit" на складе заканчивается',
				'MESSAGE' => 'Товар "Кровать Белла 160*200 велюр Monolit" скоро закончится. Остаток - 3 шт.',
				'FILES' => [
					'Кровать Белла Monolit.png',
					'Характеристики товара (Monolit).docx',
				],
			],
			[
				'TITLE' => 'Срок выполнения заказа №183964 на исходе',
				'MESSAGE' => "Просьба обратить внимание, что близится дата завершения по заказу №183964.\nДля своевременного его выполнения необходимо уточнить его статус и принять меры для ускорения обработки.",
			],
		];
	}
}