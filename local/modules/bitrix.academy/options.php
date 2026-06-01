<?php
B_PROLOG_INCLUDED === true || die();

use Bitrix\Academy\Breaker;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

global $APPLICATION, $USER;

$moduleId = "bitrix.academy";
Loader::includeModule($moduleId);

$moduleDir = __DIR__;
$siteCheckErrorScriptPath = $APPLICATION->getCurPageParam("break_1_5=Y&" . bitrix_sessid_get(), ["break_1_5", "sessid"]);
$errors = [];

$options = [
	"topics" => [
		Loc::getMessage("BITRIX_ACADEMY_OPTIONS_TOPIC_1_5"),
		[
			'note' => "<a href='$siteCheckErrorScriptPath' target='_blank'>"
				. Loc::getMessage('BITRIX_ACADEMY_OPTIONS_TOPIC_1_5_SITE_CHECK_ERROR_CREATOR_RUN')
				. "</a>",
		],
	],
];
$tabs = [
	[
		"DIV" => "topics",
		"TAB" => Loc::getMessage("BITRIX_ACADEMY_OPTIONS_TOPIC_TITLE"),
		"TITLE" => Loc::getMessage("BITRIX_ACADEMY_OPTIONS_TOPIC_TITLE"),
	],
];

if ($USER->isAdmin()) {
	if (check_bitrix_sessid() && $_GET['break_1_5']) {
		$errors = Breaker::run();
		if ($errors) {
			CAdminMessage::ShowMessage(Loc::getMessage("BITRIX_ACADEMY_OPTIONS_TOPIC_1_5_SITE_CHECK_ERROR_CREATOR_FAILED", ["#ERRORS#" => implode("<br>", $errors)]));
		}
		else {
			CAdminMessage::ShowNote(Loc::getMessage("BITRIX_ACADEMY_OPTIONS_TOPIC_1_5_SITE_CHECK_ERROR_CREATOR_DONE"));
		}
		return;
	}
	if (check_bitrix_sessid() && strlen($_POST["save"])>0) {
		foreach ($_REQUEST as &$value) {
			$value = trim($value);
		}

		unset($value);
		foreach ($options as $option) {
			__AdmSettingsSaveOptions($moduleId, $option);
		}
		LocalRedirect($APPLICATION->GetCurPageParam());
	}
}

$tabControl = new CAdminTabControl("tabControl", $tabs);
$tabControl->Begin();
?>
<form method="POST"
	  action="<?php echo $APPLICATION->GetCurPage() ?>?mid=<?=htmlspecialcharsbx($mid)?>&lang=<?=LANGUAGE_ID?>">
	<?php $tabControl->BeginNextTab(); ?>
	<?php __AdmSettingsDrawList($moduleId, $options["topics"]); ?>
	<?php $tabControl->Buttons([
		"btnApply" => false,
		"btnCancel" => false,
		"btnSaveAndAdd" => false,
	]); ?>
	<?=bitrix_sessid_post();?>
	<?php $tabControl->End(); ?>
</form>
