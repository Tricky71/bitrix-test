<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//debug($arResult);?>

<?php if (!empty($arResult)):?>
    
    <?foreach($arResult as $arItem):?>
      <?//debug($arItem['PARAMS']);?>
			<?$FILE_PERMISSION = $APPLICATION->GetFileAccessPermission($arItemLevel1["LINK"]);
            if ($FILE_PERMISSION == "D") { 
                continue; // Если доступ закрыт ("D" - Denied), пропускаем пункт меню
            }
      ?>
		    <a <?=$arItem['SELECTED'] ? 'class="active"' : ''?> href="<?=$arItem['LINK']?>">

				<?php
				if ($arItem['PARAMS']['menu_ico']) {
				?>
					<i class=<?=$arItem['PARAMS']['menu_ico'];?>></i>
				<?
				} else {
				?>
					<i class="bi-arrow-right-circle"></i>	
        <?
				}
				?>
				  <span><?=$arItem['TEXT']?></span>
				</a>
		    
		<?endforeach?>
<?endif?>

