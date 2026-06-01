<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();


$imageId = $arResult["DETAIL_PICTURE"]['ID']; 
$arResized = CFile::ResizeImageGet(
  $imageId,
  array(
        "width" => 865, 
        "height" => 865
        ),
  BX_RESIZE_IMAGE_EXACT,
  true
);

$arResult["DETAIL_PICTURE"]["RESIZED"] = $arResized;


//Schema.org

// Определяем протокол и домен один раз для всех ссылок
$protocol = (\CMain::IsHTTPS() ? 'https://' : 'http://');
$domain = $_SERVER['HTTP_HOST'] ?? SITE_SERVER_NAME;
$siteUrl = $protocol . $domain;

// 1. Заглушка для валюты и цены
$currency = 'RUB';
$price = 0;

if (!empty($arResult['MIN_PRICE']['CURRENCY'])) {
    $currency = $arResult['MIN_PRICE']['CURRENCY'];
} elseif (!empty($arResult['ITEM_PRICES']['CURRENCY'])) {
    $currency = $arResult['ITEM_PRICES']['CURRENCY'];
}

if (!empty($arResult['PROPERTIES']['PRICE']['VALUE'])) {
    $price = $arResult['PROPERTIES']['PRICE']['VALUE'];
} 

// 2. Наличие товара
$availability = "https://schema.org";
if (($arResult['CAN_BUY'] ?? false) == true || ($arResult['CATALOG_QUANTITY'] ?? 0) > 0) {
    $availability = "https://schema.org";
}

// 3. Сборка основного массива
$schemaProduct = [
    "@context" => "https://schema.org",
    "@type" => "Product",
    "name" => strip_tags($arResult['NAME'] ?? 'Товар'),
    "description" => strip_tags($arResult['PREVIEW_TEXT'] ?: $arResult['DETAIL_TEXT'] ?: $arResult['NAME'] ?: 'Описание товара'),
    "offers" => [
        "@type" => "Offer",
        "priceCurrency" => $currency,
        "price" => $price,
        "availability" => $availability,
        // "url" => SITE_SERVER_NAME . ($arResult['DETAIL_PAGE_URL'] ?? ''),
        "url" => (\CMain::IsHTTPS() ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? SITE_SERVER_NAME) . ($arResult['DETAIL_PAGE_URL'] ?? ''),
        "priceValidUntil" => date('Y-m-d', strtotime('+1 year'))
    ]
];

// 4. Фотографии товара
if (!empty($arResult['DETAIL_PICTURE']['SRC'])) {
    $schemaProduct['image'][] = $siteUrl . $arResult['DETAIL_PICTURE']['SRC'];
}
if (!empty($arResult['MORE_PHOTO'])) {
    foreach ($arResult['MORE_PHOTO'] as $photo) {
        if (!empty($photo['SRC'])) {
            $schemaProduct['image'][] = $siteUrl . $photo['SRC'];
        }
    }
}
if (empty($schemaProduct['image'])) {
    $schemaProduct['image'][] = $siteUrl . '/upload/no_photo.png';
}

// 5. Рейтинг и отзывы
if (!empty($arResult['PROPERTIES']['BLOG_COMMENTS_CNT']['VALUE'])) {
    $ratingValue = !empty($arResult['PROPERTIES']['EARNG_RATING']['VALUE']) ? $arResult['PROPERTIES']['EARNG_RATING']['VALUE'] : 5;
    $reviewCount = $arResult['PROPERTIES']['BLOG_COMMENTS_CNT']['VALUE'];
    
    $schemaProduct['aggregateRating'] = [
        "@type" => "AggregateRating",
        "ratingValue" => $ratingValue,
        "reviewCount" => $reviewCount,
        "bestRating" => "5",
        "worstRating" => "1"
    ];
}

// Передаем готовый массив в template.php через $arResult
$arResult['SCHEMA_PRODUCT'] = $schemaProduct;

// Вывод микроразметки из result_modifier.php
if (!empty($arResult['SCHEMA_PRODUCT'])) {
    \Bitrix\Main\Page\Asset::getInstance()->addString(
        '<script type="application/ld+json">' . 
        json_encode($arResult['SCHEMA_PRODUCT'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP) . 
        '</script>'
    );
}
?>

          
          
			
 
  