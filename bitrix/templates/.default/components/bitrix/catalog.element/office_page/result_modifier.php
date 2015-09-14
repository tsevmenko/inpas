<?
use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;
use Bitrix\Iblock;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$devices = array();

$db_enum_list = CIBlockProperty::GetPropertyEnum("TYPE", Array(), Array("IBLOCK_ID"=>PRODUCTS_INFOBLOCK));
while($ar_enum_list = $db_enum_list->GetNext())
	$devices[$ar_enum_list['VALUE']] = Array("IN_SERVICE" => 0, "TOTAL_COUNT" => 0, "WITH_WARRANTY" => 0, "WITHOUT_WARRANTY" => 0);

$devices['TOTAL'] = Array("IN_SERVICE" => 0, "TOTAL_COUNT" => 0, "WITH_WARRANTY" => 0, "WITHOUT_WARRANTY" => 0);

$arFilter = Array("IBLOCK_ID"=>PRODUCTS_INFOBLOCK, "ACTIVE"=>"Y", "ID" => $arResult['PREOPERTIES']['DEVICES']['VALUE']);
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement())
{
	$arProps = $ob->GetProperties();
	$devices[$arProps['TYPE']['VALUE']]['TOTAL_COUNT']++;

	$devices['TOTAL']['TOTAL_COUNT']++;

	if($arProps['END_OF_WARRANTY']['VALUE'] > date('d-m-Y') ){
		$devices[$arProps['TYPE']['VALUE']]['WITHOUT_WARRANTY']++;
		$devices['TOTAL']['WITHOUT_WARRANTY']++;
	}
	if($arProps['END_OF_WARRANTY']['VALUE'] < date('d-m-Y') ){
		$devices[$arProps['TYPE']['VALUE']]['WITH_WARRANTY']++;
		$devices['TOTAL']['WITH_WARRANTY']++;
	}
	if($arProps['BROKEN']['VALUE'] == "Y" ){
		$devices[$arProps['TYPE']['VALUE']]['IN_SERVICE']++;
		$devices['TOTAL']['IN_SERVICE']++;
	}
}
$arResult['DEVICES'] = $devices;
?>