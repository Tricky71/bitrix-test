<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
\Bitrix\Main\Loader::includeModule('mebel.custom');


$isDevServ = \Bitrix\Main\Config\Option::get('main', 'update_devsrv');
if ($isDevServ === 'Y')
{
	if (!defined('IS_DEV_SERVER'))
	{
		define('IS_DEV_SERVER', true);
	}
}

function debug($data) {
    echo'<pre>',var_dump($data),'</pre>';
};

define("DEFAULT_TEMPLATE_PATH", '/local/templates/.default');


//Redirects
use Bitrix\Main\Context;

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler("main", "OnPageStart", "RedirectOldUrls");

function RedirectOldUrls()
{
    $mapFile = __DIR__ . '/redirect_map.php';
    
    // 1. Проверяем, существует ли файл с массивом 
    if (!file_exists($mapFile)) {
        return;
    }

    // 2. Получаем точный URI из глобального массива сервера
    $requestUri = $_SERVER['REQUEST_URI'];
    
    // 3. Отсекаем любые GET-параметры (?utm_source, ?bxajaxid и т.д.), чтобы они не мешали поиску в массиве
    $uriParts = explode('?', $requestUri);
    $cleanUrl = $uriParts[0];

    // 4. Гарантируем, что адрес заканчивается на слэш
    if (substr($cleanUrl, -1) !== '/') {
        $cleanUrl .= '/';
    }
    
    // 5. Переводим всё в нижний регистр для защиты от разного написания (например, /Catalog/Product/)
    $requestedUrlLower = mb_strtolower($cleanUrl);

    // 6. Подключаем массив редиректов
    $redirectMap = include $mapFile;

    // 7. Проверяем совпадение по ключу в нижнем регистре
    if (is_array($redirectMap) && isset($redirectMap[$requestedUrlLower])) {
        // Очищаем буфер вывода на случай, если Битрикс уже успел что-то отправить
        ob_end_clean(); 
        
        // 301 редирект средствами Битрикса
        LocalRedirect($redirectMap[$requestedUrlLower], false, "301 Moved Permanently");
        die();
    }
}

//Price из csv

// Функция логгера вынесена отдельно во избежание Fatal Error при повторном вызове
function AgentImportPricesWriteToLog($message, $logPath) {
    $logMessage = "[" . date("Y-m-d H:i:s") . "] " . $message . "\n";
    @file_put_contents($logPath, $logMessage, FILE_APPEND);
}

function AgentImportPrices() {
    // Пути и настройки
    $iblockId   = 9;                                                    // ID инфоблока с товарами
    $priceProp  = "23";                                                 // ID или код свойства ЦЕНЫ 
    $csvPath    = $_SERVER["DOCUMENT_ROOT"] . "/upload/cata.csv";       // Путь к CSV-файлу
    $logPath    = $_SERVER["DOCUMENT_ROOT"] . "/upload/import_log.txt";  // Путь к файлу лога
    $delimiter  = ";";                                                  // Разделитель 

    // 1. Безопасная проверка модуля
    if (!\Bitrix\Main\Loader::includeModule('iblock')) {
        AgentImportPricesWriteToLog("ОШИБКА: модуль iblock не установлен.", $logPath);
        return "AgentImportPrices();"; 
    }

    // 2. Безопасная проверка файла (без die)
    if (!file_exists($csvPath) || !is_readable($csvPath)) {
        AgentImportPricesWriteToLog("ОШИБКА: CSV-файл не найден или недоступен по пути " . $csvPath, $logPath);
        return "AgentImportPrices();"; // Возвращаем имя, чтобы агент попробовал запуститься в следующий раз
    }

    AgentImportPricesWriteToLog("Старт импорта по Названию товара (NAME).", $logPath);

    $rowCount = 0;
    $updatedCount = 0;
    $errors = [];

    // 3. Потоковое чтение файла (экономит память и корректно обрабатывает экранирование)
    if (($handle = fopen($csvPath, "r")) !== FALSE) {
        
        while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
            $rowCount++;

            // Пропускаем заголовок таблицы
            if ($rowCount === 1) {
                continue; 
            }

            // Проверяем структуру строки
            if (count($data) < 2) {
                $errors[] = "Строка {$rowCount}: Недостаточно данных.";
                continue;
            }

            // Переводим кодировку каждой отдельной строки из Windows-1251 в UTF-8
            $productName = trim($data[0]);
            $priceRaw = trim($data[1]);

            if (!mb_check_encoding($productName, 'UTF-8')) {
                $productName = mb_convert_encoding($productName, 'UTF-8', 'Windows-1251');
            }
            if (!mb_check_encoding($priceRaw, 'UTF-8')) {
                $priceRaw = mb_convert_encoding($priceRaw, 'UTF-8', 'Windows-1251');
            }

            // Фильтруем технические строки, если они попали в середину файла
            if (preg_match('/(артикул|цена|IE_|IP_)/ui', $productName)) {
                continue; 
            }

            // Очищаем цену от мусора, пробелов и неразрывных пробелов (\xc2\xa0)
            $priceCleaned = str_replace([' ', ',', "\xc2\xa0", "\xa0"], ['', '.', '', ''], $priceRaw);
            $newPrice = floatval($priceCleaned); 

            if (empty($productName) || $newPrice <= 0) {
                $errors[] = "Строка {$rowCount}: Ошибка данных -> Название: '{$productName}', Цена: '{$priceRaw}'";
                continue;
            }

            // 4. Поиск ID товара по Названию
            $res = \CIBlockElement::GetList(
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
                
                // Обновляем цену напрямую в БД
                \CIBlockElement::SetPropertyValuesEx(
                    $elementId, 
                    $iblockId, 
                    [$priceProp => $newPrice]
                );

                // Быстрый сброс кэша элемента без вызова лишних событий
                $el = new \CIBlockElement;
                $el->Update($elementId, array("TIMESTAMP_X" => true), false, false, true);
                
                $updatedCount++;
            } else {
                $errors[] = "Строка {$rowCount}: Товар с названием '{$productName}' не найден.";
            }
        }
        fclose($handle);
    }

    // 5. Запись результатов в лог
    $endMessage = "Импорт завершен. Всего строк обработано: {$rowCount}. Успешно обновлено: {$updatedCount}. Ошибок/Пропусков: " . count($errors);
    AgentImportPricesWriteToLog($endMessage, $logPath);

    if (!empty($errors)) {
        AgentImportPricesWriteToLog("--- Детализация ошибок ---", $logPath);
        foreach ($errors as $error) {
            AgentImportPricesWriteToLog($error, $logPath);
        }
        AgentImportPricesWriteToLog("--------------------------", $logPath);
    }
    AgentImportPricesWriteToLog("==========================================", $logPath);

    // Возвращаем вызов функции для планировщика Битрикс
    return "AgentImportPrices();";
}