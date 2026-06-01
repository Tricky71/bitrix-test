<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}
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
$this->setFrameMode(true);?>

<h4><?=GetMessage('BSF_T_SEARCH_TITLE')?></h4>
<form action="<?=$arResult['FORM_ACTION']?>">
	<div class="search-form">
		<input class="input-seach" type="text" name="q" value="" size="15" maxlength="50" />
		<input class="button-seach" name="s" type="submit" value="<?=GetMessage('BSF_T_SEARCH_BUTTON');?>" />
	</div>
</form>

<!-- 
	<h4>Поиск</h4>
						<form action="#" method="post">
							<div class="search-form">
								<input class="input-seach" type="text" name="q">
								<input class="button-seach" name="s" type="submit" value="Найти">
							</div>
						</form> -->