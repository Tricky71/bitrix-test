<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
use Bitrix\Catalog\ProductTable;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
  // debug($arResult['SCHEMA_PRODUCT']);
//  debug(SITE_SERVER_NAME);
?>

<?php if (!empty($arResult)): ?>
   
        <!-- Portfolio Details Section -->
    <section class="portfolio-details section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider">

            <?if(!empty($arResult["DETAIL_PICTURE"]["RESIZED"])):?>

              <img src="<?=$arResult["DETAIL_PICTURE"]["RESIZED"]['src']?>" alt="<?=$arResult['DETAIL_PICTURE']['ALT']?>">

            <?endif?>  

            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3><?=GetMessage('ELEM_PROJ')?></h3>
              <ul>
                <li><strong><?=GetMessage('ELEM_SERV')?></strong>: <?=$arResult['SECTION']['NAME']?></li>
					      <li>
									<strong><?=GetMessage('ELEM_DEV')?></strong>
								<?php if ($arResult['PROPERTIES']['BUSINESS_SECTOR']): ?>
								  : <?=$arResult['PROPERTIES']['BUSINESS_SECTOR']['VALUE']?>
								<?endif?>	
								</li>
                <li>
									<strong><?=GetMessage('ELEM_COMP')?></strong>
								<?php if ($arResult['PROPERTIES']['CLIENT_NAME']): ?>
								  : <?=$arResult['PROPERTIES']['CLIENT_NAME']['VALUE']?>
								<?endif?>	
								</li>
              </ul>
            </div>
            <div class="portfolio-description">
              <h2><?=$arResult['NAME']?></h2>
              <p><?=$arResult['DETAIL_TEXT']?></p>              
            </div>
            <div>
              <a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>"><b>В список</b></a>
            </div>

          </div>

        </div>

      </div>

    </section><!-- /Portfolio Details Section -->

<?endif?>