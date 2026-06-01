<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();



foreach($arResult["SECTIONS"] as &$arSection):?>
		<?php $imageId = $arSection["PICTURE"]['ID']; 
            $arResized = CFile::ResizeImageGet(
							$imageId,
							array("width" => 574, "height" => 430),
							BX_RESIZE_IMAGE_EXACT,
							true
					  );
					
          $arSection["PICTURE"]["RESIZED"] = $arResized;
          unset($arSection);
          
          
		?>	
<?endforeach?>   
  