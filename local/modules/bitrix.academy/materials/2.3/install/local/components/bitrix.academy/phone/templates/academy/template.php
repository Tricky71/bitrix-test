<?php B_PROLOG_INCLUDED === true || die();

/**
 * @var array $arResult
 * @var array $arParams
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);
?>
<? if ($arResult["PHONE"]): ?>
	<a class="<?=$arParams["HTML_CLASS"]?>" href="tel:<?=$arResult["PHONE"]?>">
		<?=$arResult["DISPLAY_PHONE"]?>
	</a>
<? endif ?>