<?
/**
 * @global \CMain $APPLICATION
 */
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("1С-Битрикс22 обучение");
?>

<?// $APPLICATION->IncludeComponent('ylab:users.list', '', []); ?>

<?
$APPLICATION->IncludeComponent('ylab:validation.test','');

?>


<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>