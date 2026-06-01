<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
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
$this->setFrameMode(true);
?>
<?//php debug($arResult);?>
<div class="row">
	<div class="col-lg-12">

		<div class="card">
			<div class="card-body">

				<div class="d-flex py-4 px-4">

      <?if($arResult['ITEMS']): ?>

					<table class="table table-striped">
						<thead>
							<tr>
								<th>№</th>
								<th><?=GetMessage('NAME_PRODUCT')?></th>
								<th><?=GetMessage('NAME_PRODUCT_CATEGORY')?></th>
								<th><?=GetMessage('NAME_CITY')?></th>
								<th><?=GetMessage('NAME_QUANTITY')?></th>
							</tr>
						</thead>
						<tbody class="ajax-items-container">

          <?foreach ($arResult['ITEMS'] as $arItem): ?>

							<tr>
								<td><?=$arItem['NAME']?></td>
								<td><a href="<?=$arItem['DETAIL_PAGE_URL']?>"><?=$arItem['PROPERTIES']['PRODUCT']['VALUE']?></a></td>
								<td><?=$arItem['PROPERTIES']['PRODUCT_CATEGORY']['VALUE']?></td>
								<td><?=$arItem['PROPERTIES']['CITY']['VALUE']?></td>
								<td><?=$arItem['PROPERTIES']['QUANTITY']['VALUE']?></td>
							</tr>

					<?endforeach?>

						</tbody>
					</table>

			<?endif?>

				</div>
		
				<!-- <div class="d-flex py-2 px-4 flex-column"> -->
						<?//if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
							<?//=$arResult["NAV_STRING"]?>
						<?//endif?>
				<!-- </div> -->

				<!-- 2. Блок с кнопкой "Показать еще" -->
				<?if($arResult["NAV_RESULT"]->NavPageNomer < $arResult["NAV_RESULT"]->NavPageCount):
						// Получаем стандартную ссылку на следующую страницу, которую сгенерировал комплексный компонент
						$nextPageNum = $arResult["NAV_RESULT"]->NavPageNomer + 1;
						$navNum = $arResult["NAV_RESULT"]->NavNum;
						
						// GetCurPageParam сформирует идеальный URL с учетом ЧПУ комплексного компонента
						$nextPageUrl = $APPLICATION->GetCurPageParam(
								'PAGEN_'.$navNum.'='.$nextPageNum, 
								array('PAGEN_'.$navNum)
						);
				?>
						<div class="ajax-nav-wrapper">
								<!-- Важно: вешаем на кнопку обычную ссылку href, чтобы Битрикс перехватил клик -->
								<a href="<?=$nextPageUrl?>" class="btn-show-more">Показать еще</a>
						</div>
				<?endif;?>

			</div>
		</div>

	</div>
</div>