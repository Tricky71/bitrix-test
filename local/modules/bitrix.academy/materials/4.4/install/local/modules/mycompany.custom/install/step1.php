<?php

use Bitrix\Main\Localization\Loc;

if (!check_bitrix_sessid()) {
	return;
}

Loc::loadMessages(__FILE__);

global $APPLICATION;
?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
	<?= bitrix_sessid_post() ?>
	<input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
	<input type="hidden" name="id" value="mycompany.custom">
	<input type="hidden" name="install" value="Y">
	<input type="hidden" name="step" value="2">
	<p><?=Loc::getMessage("MY_COMPANY_CUSTOM_ADD_DATA")?></p>
	<p>
		<input type="checkbox" name="addData" id="addData" value="Y" checked>
		<label for="addData"><?=Loc::getMessage("MY_COMPANY_CUSTOM_ADD_DATA_LABEL")?></label>
	</p>
	<input type="submit" name="" value="<?=Loc::getMessage("MY_COMPANY_CUSTOM_SUBMIT")?>">
</form>
