<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>



<?if (!empty($arResult)):?>
<?//debug($arResult)?>
<ul>
    <?foreach($arResult as $arItemLevel1):?>
        <?$FILE_PERMISSION = $APPLICATION->GetFileAccessPermission($arItemLevel1["LINK"]);
            if ($FILE_PERMISSION == "D") { 
                continue; // Если доступ закрыт ("D" - Denied), пропускаем пункт меню
            }
        ?>
        <li <?=$arItemLevel1['SUBITEMS'] ? 'class="dropdown"' : ''?>>
            <a href="<?=$arItemLevel1["LINK"]?>">
                <?=$arItemLevel1["TEXT"]?>
                <?php if (!empty($arItemLevel1['SUBITEMS'])): ?>
                        <span>
                                <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </span>
                        </a>
                <?php endif; ?>
            </a>
            
            <?if(!empty($arItemLevel1["SUBITEMS"])): // 2 уровень?>
                <ul>
                    <?foreach($arItemLevel1["SUBITEMS"] as $arItemLevel2):?>
                        <li <?=$arItemLevel2['SUBITEMS'] ? 'class="dropdown"' : ''?>>
                            <a href="<?=$arItemLevel2["LINK"]?>"><?=$arItemLevel2["TEXT"]?></a>
                            
                            <?if(!empty($arItemLevel2["SUBITEMS"])): // 3 уровень?>
                                <ul>
                                    <?foreach($arItemLevel2["SUBITEMS"] as $arItemLevel3):?>
                                        <li><a href="<?=$arItemLevel3["LINK"]?>"><?=$arItemLevel3["TEXT"]?></a></li>
                                    <?endforeach?>
                                </ul>
                            <?endif?>
                            
                        </li>
                    <?endforeach?>
                </ul>
            <?endif?>
            
        </li>
    <?endforeach?>
</ul>
<?endif?>