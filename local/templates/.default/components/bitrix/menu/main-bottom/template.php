<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?//debug($arResult);?>

<?php if (!empty($arResult)):?>
  <ul>
    <?foreach($arResult as $arItem):?>
      <?//debug($arItem['PARAMS']);?>
			<?$FILE_PERMISSION = $APPLICATION->GetFileAccessPermission($arItemLevel1["LINK"]);
            if ($FILE_PERMISSION == "D") { 
                continue; // Если доступ закрыт ("D" - Denied), пропускаем пункт меню
            }
      ?>
		    <li>  
          <i class="bi bi-chevron-right"></i>
					<a href="<?=$arItem['LINK']?>"><?=$arItem['TEXT']?></a>
				</li>
		    
		<?endforeach?>
	</ul>	
<?endif?>


