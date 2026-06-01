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