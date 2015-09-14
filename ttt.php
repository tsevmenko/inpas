<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("ttt");

$objData = serialize( $_POST);
$filePath = $_SERVER['DOCUMENT_ROOT']."/notice.txt";
d($filePath);

file_put_contents($filePath, $objData);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>