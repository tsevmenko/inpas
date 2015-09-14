<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<? 
CModule::IncludeModule("iblock");
$arFilter = Array("IBLOCK_ID" => PRODUCTS_INFOBLOCK, "PROPERTY_SERIAL_NUMBER_VALUE" => "541 901");//$_REQUEST['ids']);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetProperties();
	d($arFields['SERIAL_NUMBER']['VALUE']);
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>