<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="sidebar-nav" id="sidebar-nav">

    <?foreach($arResult as $key1 => $arItemLevel1):?>
        <?$FILE_PERMISSION = $APPLICATION->GetFileAccessPermission($arItemLevel1["LINK"]);
            if ($FILE_PERMISSION == "D") { 
                continue; // Если доступ закрыт ("D" - Denied), пропускаем пункт меню
            }
        ?>
        <?
        // Генерируем уникальный ID для каждого пункта меню
        $targetId = "nav-target-" . $key1;
        ?>
        <li class="nav-item">
            <a class="nav-link <?=!$arItemLevel1['SELECTED'] ? 'collapsed' : ''?>"
              <?if(!empty($arItemLevel1["SUBITEMS"])):?> 
                data-bs-target="#<?=$targetId?>" 
                data-bs-toggle="collapse" 
              <?endif?>
              href="<?=$arItemLevel1["LINK"]?>">
              
              <?if (!empty($arItemLevel1['PARAMS']['menu_ico'])): ?>
                  <i class="<?=$arItemLevel1['PARAMS']['menu_ico'];?>"></i>
              <?endif?>
              
              <span><?=$arItemLevel1['TEXT']?></span>
              
              <?if (!empty($arItemLevel1['SUBITEMS'])): ?>
                  <i class="bi bi-chevron-down ms-auto"></i>
              <?endif?>
            </a>
            
        <?if(!empty($arItemLevel1["SUBITEMS"])): // 2 уровень?>
            <ul id="<?=$targetId?>" 
                class="nav-content collapse <?=$arItemLevel1['SELECTED'] ? 'show' : ''?>" 
                data-bs-parent="#sidebar-nav">
                
            <?foreach($arItemLevel1["SUBITEMS"] as $arItemLevel2):?>
                <li class="nav-item">
                    <a href="<?=$arItemLevel2["LINK"]?>" class="<?=$arItemLevel2['SELECTED'] ? 'active' : ''?>">
                        <i class="bi bi-circle"></i>
                        <span><?=$arItemLevel2['TEXT']?></span>
                    </a>
                        
                    <?if(!empty($arItemLevel2["SUBITEMS"])): // 3 уровень?>
                        <ul>
                            <?foreach($arItemLevel2["SUBITEMS"] as $arItemLevel3):?>
                                <li>
                                    <a href="<?=$arItemLevel3["LINK"]?>" class="<?=$arItemLevel3['SELECTED'] ? 'active' : ''?>">
                                        <?=$arItemLevel3["TEXT"]?>
                                    </a>
                                </li>
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