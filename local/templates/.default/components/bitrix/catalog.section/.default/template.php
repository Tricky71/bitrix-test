<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Catalog\ProductTable;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 *
 *  _________________________________________________________________________
 * |	Attention!
 * |	The following comments are for system use
 * |	and are required for the component to work correctly in ajax mode:
 * |	<!-- items-container -->
 * |	<!-- pagination-container -->
 * |	<!-- component-end -->
 */

$this->setFrameMode(true);
// $this->addExternalCss('/bitrix/css/main/bootstrap.css');

?>

<?//php debug($arResult['ITEMS']);?>

<?php if (!empty($arResult["ITEMS"])): ?>
<section class="portfolio section">

	<div class="container">
		<div class="row gy-4">
<?//php debug($arResult);?>
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<?//debug($arItem['RESIZED']);?>
		  <?//php $imageId = $arItem["DETAIL_PICTURE"]['ID']; 
            //$arResized = CFile::ResizeImageGet(
							//$imageId,
							// array("width" => 574, "height" => 430),
							// BX_RESIZE_IMAGE_EXACT,
							//true
					  //);
					?>	

			<div class="col-lg-4">
				<article>
					<div class="post-img">

					<?php if (!empty($arItem["DETAIL_PICTURE"]["RESIZED"])): ?>
			
					  <img src="<?=$arItem["DETAIL_PICTURE"]["RESIZED"]['src']?>" alt="<?=$arItem['DETAIL_PICTURE']['ALT']?>" class="img-fluid">
					<?endif?>	
						
					</div>
					<div class="card-body">
						<h5 class="title"><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['NAME']?></a></h5>
						<p class="card-text"><?=$arItem['PREVIEW_TEXT']?></p>
					</div>
				</article>
			</div><!-- End list item -->

		<?endforeach?>		
		<?if($arResult['NAV_STRING']):?>
		  <?=$arResult['NAV_STRING']?>
		<?endif?>
		</div>

	</div><!-- End Portfolio Container -->

	</section><!-- /Portfolio List Section -->
<?endif?>	