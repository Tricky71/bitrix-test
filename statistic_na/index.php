<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Статистика");
use Bitrix\Main\Application;

$redirect = Application::getInstance()->getContext()->getResponse()->redirectTo('/statistic_na/dashboard/');
Application::getInstance()->end(0, $redirect);
?>

Text here....

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>