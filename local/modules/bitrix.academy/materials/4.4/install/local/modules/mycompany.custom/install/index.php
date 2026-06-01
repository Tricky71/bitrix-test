<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\EventManager;
use MyCompany\Custom\EventHandlers\Notification;
use MyCompany\Custom\Notification\NotificationTable;
use MyCompany\Custom\Notification\NotificationFileTable;
use MyCompany\Custom\Notification\Data\Generator;

Loc::loadMessages(__FILE__);

class mycompany_custom extends CModule
{
	/**
	 * @return string
	 */
	public static function getModuleId(): string
	{
		return basename(dirname(__DIR__));
	}

	public function __construct()
	{
		$arModuleVersion = array();
		include(dirname(__FILE__) . "/version.php");
		$this->MODULE_ID = self::getModuleId();
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = Loc::getMessage("MY_COMPANY_CUSTOM_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("MY_COMPANY_CUSTOM_MODULE_DESC");

		$this->PARTNER_NAME = Loc::getMessage("MY_COMPANY_CUSTOM_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("MY_COMPANY_CUSTOM_PARTNER_URI");
	}

	public function doInstall(): bool
	{
		global $APPLICATION;

		try
		{
			$context = Application::getInstance()->getContext();
			$request = $context->getRequest();

			if ($request['step'] < 2)
			{
				$APPLICATION->IncludeAdminFile(
					Loc::getMessage("MY_COMPANY_CUSTOM_STEP_1_TITLE"),
					__DIR__ . '/step1.php'
				);
			}
			elseif ($request['step'] == 2)
			{
				Main\ModuleManager::registerModule($this->MODULE_ID);
				$isDbInstalled = $this->InstallDB();
				if ($isDbInstalled && $request['addData'] == 'Y')
				{
					$this->addTestData();
				}

				$this->InstallEvents();
				$this->InstallFiles();
			}
		}
		catch (Exception $e)
		{
			$APPLICATION->ThrowException($e->getMessage());
			return false;
		}

		return true;
	}

	public function doUninstall(): bool
	{
		try
		{
			$this->UnInstallFiles();
			$this->UnInstallEvents();
			$this->UnInstallDB();
			Main\ModuleManager::unRegisterModule($this->MODULE_ID);
		}
		catch (Exception $e)
		{
			global $APPLICATION;
			$APPLICATION->ThrowException($e->getMessage());
			return false;
		}

		return true;
	}

	public function InstallDB(): bool
	{
		if (!Loader::includeModule($this->MODULE_ID))
		{
			return false;
		}

		$dbCon = Application::getConnection();

		$entity = NotificationTable::getEntity();
		$tableName = NotificationTable::getTableName();
		if(!$dbCon->isTableExists($tableName))
		{
			$entity->createDbTable();
		}

		$entity = NotificationFileTable::getEntity();
		$tableName = NotificationFileTable::getTableName();
		if (!$dbCon->isTableExists($tableName))
		{
			$entity->createDbTable();
		}

		return true;
	}

	public function UnInstallDB(): bool
	{
		if (!Loader::includeModule($this->MODULE_ID))
		{
			return false;
		}

		$dbCon = Application::getConnection();

		$tableName = NotificationTable::getTableName();
		$dbCon->queryExecute('DROP TABLE IF EXISTS ' . $tableName);

		$tableName = NotificationFileTable::getTableName();
		$dbCon->queryExecute('DROP TABLE IF EXISTS ' . $tableName);

		return true;
	}

	public function InstallFiles(): void
	{
		$root = Application::getDocumentRoot();
		copyDirFiles(
			$root . '/local/modules/mycompany.custom/install/components',
			$root . '/local/components/mycompany.custom',
			true,
			true
		);

		copyDirFiles(
			$root . '/local/modules/mycompany.custom/install/files/css',
			$root . '/bitrix/js/mycompany.custom/css',
			true,
			true
		);
	}

	public function UnInstallFiles(): void
	{
		$root = Application::getDocumentRoot();
		Directory::deleteDirectory($root . '/local/components/mycompany.custom');
		Directory::deleteDirectory($root . '/bitrix/js/mycompany.custom');
	}

	public function InstallEvents(): void
	{
		if (!Loader::includeModule($this->MODULE_ID))
		{
			return;
		}

		$em = EventManager::getInstance();
		$em->registerEventHandler(
			NotificationTable::class,
			DataManager::EVENT_ON_BEFORE_UPDATE,
			$this->MODULE_ID,
			Notification::class,
			'prohibitAddingReadNotifications'
		);
	}

	public function UnInstallEvents(): void
	{
		if (!Loader::includeModule($this->MODULE_ID))
		{
			return;
		}

		$em = EventManager::getInstance();
		$em->unRegisterEventHandler(
			NotificationTable::class,
			DataManager::EVENT_ON_BEFORE_UPDATE,
			$this->MODULE_ID,
			Notification::class,
			'prohibitAddingReadNotifications'
		);
	}

	protected function addTestData(): void
	{
		global $USER;
		$generator = new Generator();
		$generator->generateCount(count: 50, userId: $USER->getId());
		$generator->generateCount(count: 100);
	}
}