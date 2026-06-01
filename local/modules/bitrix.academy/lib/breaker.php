<?php
namespace Bitrix\Academy;

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\IO\File;
use Bitrix\Main\Localization\Loc;

class Breaker
{
	protected static $errors = [];

	public static function run()
	{
		static::$errors = [];
		global $USER;

		if ($USER->isAdmin()) {
			static::addServiceScript();
			static::dropIndex();
			static::changeFileMode();
			static::disableAgentsCrontab();
		} else {
			static::$errors[] = Loc::getMessage('BITRIX_ACADEMY_ACCESS_DENIED');
		}

		return static::$errors;
	}

	protected static function addServiceScript()
	{
		$from = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/bitrix.academy/materials/1.5/bitrixsetup.php";
		$to = $_SERVER["DOCUMENT_ROOT"] . "/bitrixsetup.php";

		if (!File::isFileExists($from)) {
			static::$errors[] = Loc::getMessage('BITRIX_ACADEMY_FILE_NOT_FOUND', ['#FILE#' => $from]);
		} elseif (!File::isFileExists($to)) {
			$res = File::putFileContents($to, File::getFileContents($from));
			if (!$res) {
				static::$errors[] = Loc::getMessage('BITRIX_ACADEMY_COPY_FILE_ERROR', [
					'#FROM#' => $from,
					'#TO#' => $to,
				]);
			}
		}
	}

	protected static function dropIndex()
	{
		$db = Application::getConnection();
		$indexName = $db->getIndexName('b_user', ['LOGIN']);
		if ($indexName) {
			$indexName = $db->getSqlHelper()->forSql($indexName);
			try {
				$db->query("DROP INDEX $indexName ON b_user;");
			} catch (SqlQueryException $e) {
				static::$errors[] = Loc::getMessage('BITRIX_ACADEMY_DROP_INDEX_ERROR', ['#ERROR#' => $e->getMessage()]);
			}
		}
	}

	protected static function changeFileMode()
	{
		$filePath = $_SERVER["DOCUMENT_ROOT"] . "/search/index.php";
		$res = chmod($filePath, 0444);
		if (!$res) {
			static::$errors[] = Loc::getMessage('BITRIX_ACADEMY_CHANGE_FILE_MODE_FAILED', ['#FILE#' => $filePath]);
		}
	}

	protected static function disableAgentsCrontab()
	{
		Option::set('main', 'agents_use_crontab', 'N');
		Option::set('main', 'check_agents', 'Y');

		if (defined('BX_CRONTAB_SUPPORT') && BX_CRONTAB_SUPPORT === true) {
			$dbconnPath = $_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/dbconn.php";
			$dbconnContent = File::getFileContents($dbconnPath);
			$dbconnContent = str_replace(
				'define("BX_CRONTAB_SUPPORT", true)',
				'define("BX_CRONTAB_SUPPORT", false)',
				$dbconnContent
			);

			File::putFileContents($dbconnPath, $dbconnContent);
		}
	}
}