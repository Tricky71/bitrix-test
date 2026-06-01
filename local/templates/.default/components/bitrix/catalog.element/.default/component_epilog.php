<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

// 1. Формируем абсолютную ссылку на страницу
$protocol = (\Bitrix\Main\Context::getCurrent()->getRequest()->isHttps()) ? "https://" : "http://";
$pageUrl = $protocol . $_SERVER["HTTP_HOST"] . $APPLICATION->GetCurPage();
$APPLICATION->SetPageProperty("og:url", $pageUrl);

// 2. Передаем заголовок (если нужно переопределить стандартный)
if (!empty($arResult["NAME"])) {
    $APPLICATION->SetPageProperty("og:title", htmlspecialcharsbx($arResult["NAME"]));
}

// 3. Передаем описание (анонс или SEO-описание)
$description = !empty($arResult["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"]) 
    ? $arResult["IPROPERTY_VALUES"]["ELEMENT_META_DESCRIPTION"] 
    : $arResult["PREVIEW_TEXT"];

if (!empty($description)) {
    $APPLICATION->SetPageProperty("og:description", htmlspecialcharsbx(strip_tags($description)));
}

// 4. Передаем картинку (Детальное фото -> Превью фото)
$imgSrc = "";
if (!empty($arResult["DETAIL_PICTURE"])) {
    $imgSrc = $arResult["DETAIL_PICTURE"]["SRC"];
} elseif (!empty($arResult["PREVIEW_PICTURE"])) {
    $imgSrc = $arResult["PREVIEW_PICTURE"]["SRC"];
}

if (!empty($imgSrc)) {
    $absoluteImgUrl = $protocol . $_SERVER["HTTP_HOST"] . $imgSrc;
    $APPLICATION->SetPageProperty("og:image", $absoluteImgUrl);
}