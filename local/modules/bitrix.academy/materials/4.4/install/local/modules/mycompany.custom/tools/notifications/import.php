<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use MyCompany\Custom\Notification\Data\Generator;

$docRoot = dirname(__DIR__, 5);
include_once($docRoot . '/bitrix/modules/main/cli/bootstrap.php');
while (ob_end_flush());

Loader::includeModule('mycompany.custom');

$options = getopt('', ['count:']);
if (!isset($options['count']))
{
	throw new RuntimeException('Required parameter "count" is missing.' . PHP_EOL);
}

$count = (int)$options['count'];
if ($count <= 0)
{
	throw new RuntimeException('Incorrect value for parameter "count"' . PHP_EOL);
}

$root = Application::getDocumentRoot();
$dataGenerator = new Generator();
$dataGenerator->generateCount($count);
