<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();



foreach($arResult["ITEMS"] as &$arItem):?>
		<?php $imageId = $arItem["DETAIL_PICTURE"]['ID']; 
          $arResized = CFile::ResizeImageGet(
            $imageId,
            array("width" => 425, "height" => 425),
            BX_RESIZE_IMAGE_EXACT,
            true
          );
          $arItem["DETAIL_PICTURE"]["RESIZED"] = $arResized;
          unset($arItem);
          
          
		?>	
<?endforeach?>   
  