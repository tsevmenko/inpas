<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;
use Bitrix\Iblock;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arSelect = Array("ID", "NAME", "CODE");
$arFilter = Array("IBLOCK_ID"=>10, "PROPERTY_ORA_ID" => $arResult['PROPERTIES']['OWNER']['VALUE']);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNext())
{
	$arResult['PROPERTIES']['OWNER']['VALUE'] = $ob['NAME'];
}

?>