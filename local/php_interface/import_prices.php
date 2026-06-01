<?php
// 1. Защита: запуск только через консоль (CLI / Cron)
// if (php_sapi_name() !== 'cli') {
//     die("Доступ только через консоль.");
// }

// 2. Отключаем сбор статистики и инициализируем ядро Битрикса
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define("BX_NO_ACCELERATOR_RESET", true);

$_SERVER["DOCUMENT_ROOT"] = realpath(dirname(__FILE__) . '/../..'); // путь до корня
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;

// 3. БЛОК НАСТРОЕК 
$iblockId   = 9;                  // ID инфоблока с товарами
$priceProp  = "23";                // Символьный код свойства ЦЕНЫ 
$csvPath    = $_SERVER["DOCUMENT_ROOT"] . "/upload/cata.csv"; // Путь к CSV-файлу
$logPath    = $_SERVER["DOCUMENT_ROOT"] . "/upload/import_log.txt"; // Путь к файлу лога
$delimiter  = ";";                 // Разделитель 

// Функция для записи в лог-файл
function writeToLog($message, $logPath) {
    $logMessage = "[" . date("Y-m-d H:i:s") . "] " . $message . "\n";
    file_put_contents($logPath, $logMessage, FILE_APPEND);
}

// 4. Проверки
if (!Loader::includeModule("iblock")) {
    writeToLog("ОШИБКА: модуль iblock не установлен.", $logPath);
    die("Ошибка: модуль iblock не установлен.\n");
}
if (!file_exists($csvPath) || !is_readable($csvPath)) {
    writeToLog("ОШИБКА: CSV-файл не найден по пути " . $csvPath, $logPath);
    die("Ошибка: CSV-файл не найден.\n");
}

$startMessage = "Старт импорта по Названию товара (NAME).";
echo $startMessage . "\n";
writeToLog($startMessage, $logPath);

// Читаем файл целиком в строку
$fileContent = file_get_contents($csvPath);

// Исправляем кодировку Excel (Windows-1251) в UTF-8
if (!mb_check_encoding($fileContent, 'UTF-8')) {
    $fileContent = mb_convert_encoding($fileContent, 'UTF-8', 'Windows-1251');
}

// Нормализуем переносы строк
$fileContent = str_replace(["\r\n", "\r"], "\n", $fileContent);
$lines = explode("\n", $fileContent);

$rowCount = 0;
$updatedCount = 0;
$errors = [];

foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line)) {
        continue; 
    }

    $rowCount++;

    // Пропускаем заголовок таблицы
    if ($rowCount === 1 || preg_match('/(артикул|цена|IE_|IP_)/ui', $line)) {
        continue; 
    }

    // Разбиваем строку по точке с запятой
    $data = explode($delimiter, $line);

    if (count($data) < 2) {
        $errors[] = "Строка {$rowCount}: Недостаточно данных. Строка: '{$line}'";
        continue;
    }

    $productName = trim($data[0]);
    $priceRaw = trim($data[1]); 

    // Очищаем цену от пробелов и приводим к числу
    $newPrice = floatval(str_replace([' ', ',', "\xc2\xa0"], ['', '.', ''], $priceRaw)); 

    if (empty($productName) || $newPrice <= 0) {
        $errors[] = "Строка {$rowCount}: Ошибка данных -> Название: '{$productName}', Цена: '{$priceRaw}'";
        continue;
    }

    // ИЩЕМ ВНУТРЕННИЙ ID ТОВАРА ПО ЕГО НАЗВАНИЮ (NAME)
    $res = CIBlockElement::GetList(
        [], 
        [
            "IBLOCK_ID" => $iblockId, 
            "=NAME"     => $productName
        ], 
        false, 
        ["nTopCount" => 1], 
        ["ID"]
    );

    if ($element = $res->Fetch()) {
        $elementId = $element["ID"];
        
        // Обновляем свойство цены напрямую
        CIBlockElement::SetPropertyValuesEx(
            $elementId, 
            $iblockId, 
            [$priceProp => $newPrice]
        );

        // Безопасный сброс кэша элемента
        $el = new CIBlockElement;
        $el->Update($elementId, array("TIMESTAMP_X" => true), false, false, true);
        
        $updatedCount++;
    } else {
        $errors[] = "Строка {$rowCount}: Товар с названием '{$productName}' не найден в инфоблоке №{$iblockId}.";
    }
}

// отчет для лога
$endMessage = "Импорт завершен. Всего строк: {$rowCount}. Успешно обновлено: {$updatedCount}. Ошибок/Пропусков: " . count($errors);
echo "----------------------------------------\n" . $endMessage . "\n";
writeToLog($endMessage, $logPath);

// Если были ошибки, детально записываем их в лог
if (!empty($errors)) {
    writeToLog("--- Детализация ошибок ---", $logPath);
    foreach ($errors as $error) {
        writeToLog($error, $logPath);
        echo $error . "\n"; // Также выводим в консоль для наглядности
    }
    writeToLog("--------------------------", $logPath);
}
writeToLog("==========================================", $logPath);