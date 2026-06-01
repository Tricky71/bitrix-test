<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<?//php debug($arResult);?>
<?php if (!empty($arResult["SECTIONS"])): ?>
		<section class="portfolio-sections section">
			<div class="container">
				<div class="row gy-4">

        <?foreach($arResult["SECTIONS"] as $arSection): ?>


					<div class="col-lg-6">
						<div class="service-item position-relative">
							<div class="img">

							<?php if (!empty($arSection["PICTURE"]["RESIZED"])):?>
                <img src="<?=$arSection["PICTURE"]["RESIZED"]['src']?>" class="img-fluid" alt="">
							<?endif?>	
							</div>
							<div class="details">
								<a href="<?=$arSection['SECTION_PAGE_URL']?>">
									<?=$arSection['NAME']?>
								</a>
								<p><?=$arSection['DESCRIPTION']?></p>
							</div>
						</div>
					</div><!-- End Service Item -->

				<?endforeach?>	


				</div>
			</div>
<?endif?>