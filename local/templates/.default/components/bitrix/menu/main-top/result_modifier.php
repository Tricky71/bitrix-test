<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arMenuTree = [];
$levLinks = []; // Массив указателей на текущие родительские элементы

foreach ($arResult as $arItem) {
    $level = $arItem["DEPTH_LEVEL"];
    $arItem["SUBITEMS"] = []; // Сразу создаем ключ для будущих потомков

    if ($level == 1) {
        $arMenuTree[] = $arItem;
        // Запоминаем ссылку на последний добавленный элемент 1-го уровня
        $levLinks[$level] = &$arMenuTree[count($arMenuTree) - 1];
    } else {
        // Кладем элемент в SUBITEMS родителя предыдущего уровня
        $levLinks[$level - 1]["SUBITEMS"][] = $arItem;
        // Запоминаем ссылку на этот элемент для следующего уровня (если он будет)
        $parentSubitems = &$levLinks[$level - 1]["SUBITEMS"];
        $levLinks[$level] = &$parentSubitems[count($parentSubitems) - 1];
    }
}

$arResult = $arMenuTree;