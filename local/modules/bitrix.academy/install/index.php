<?php
B_PROLOG_INCLUDED === true || die();

use Bitrix\Main;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;

Loc::loadMessages(__FILE__);

class bitrix_academy extends CModule
{
	var $MODULE_ID = 'bitrix.academy';

	/**
	 * @return string
	 */
	public static function getModuleId()
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
		$this->MODULE_NAME = Loc::getMessage("BITRIX_ACADEMY_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("BITRIX_ACADEMY_MODULE_DESC");

		$this->PARTNER_NAME = Loc::getMessage("BITRIX_ACADEMY_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("BITRIX_ACADEMY_PARTNER_URI");
	}

	public function DoInstall()
	{
		try {
			Main\ModuleManager::registerModule($this->MODULE_ID);
			$this->InstallFiles();
			$this->InstallAgents();
		} catch (Throwable $t) {
			global $APPLICATION;
			$APPLICATION->throwException($t->getMessage());

			return false;
		}

		return true;
	}

	public function DoUninstall()
	{
		try {
			Main\ModuleManager::unRegisterModule($this->MODULE_ID);
			$this->UninstallFiles();
			$this->UninstallAgents();
		} catch (Throwable $t) {
			global $APPLICATION;
			$APPLICATION->throwException($t->getMessage());

			return false;
		}

		return true;
	}

	public function InstallFiles()
	{
		$root = Application::getDocumentRoot();
		copyDirFiles(
			$root . '/bitrix/modules/bitrix.academy/install/.default',
			$root . '/local/templates/.default',
			true,
			true
		);

		copyDirFiles(
			$root . '/bitrix/modules/bitrix.academy/materials/2.2/test.php',
			$root . '/bxacademy2_2/test.php',
		);

		copyDirFiles(
			$root . '/bitrix/modules/bitrix.academy/materials/2.2/init.example.php',
			$root . '/local/php_interface/init.example.php',
			false
		);
	}

	public function UninstallFiles()
	{
		$root = Application::getDocumentRoot();
		deleteDirFiles(
			$root . '/bitrix/modules/bitrix.academy/install/.default',
			$root . '/local/templates/.default'
		);

		DeleteDirFilesEx('/bxacademy2_2');
		DeleteDirFilesEx('/local/php_interface/init.example.php');
	}

	public function InstallAgents()
	{
		CAgent::AddAgent('checkNewsCountAgent();', $this->MODULE_ID, 'N', 86400, '', 'N');
	}

	public function UninstallAgents()
	{
		CAgent::RemoveAgent('checkNewsCountAgent%', $this->MODULE_ID);
	}
}