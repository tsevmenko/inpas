<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
CModule::IncludeModule("iblock");
//get ids from office or bank
$bankName = "";
if($_REQUEST['BANK'] != "none" && $_REQUEST['OFFICE'] == 'none'){

	$arFilter = Array("IBLOCK_ID"=>OFFICE_INFOBLOCK, "PROPERTY_BANK" => $_REQUEST['BANK'], "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array());
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetProperties();
		foreach($arFields['DEVICES']['VALUE'] as $k => $v){
			$ids[] = $v;
		}
	}

}
if($_REQUEST['OFFICE'] != 'none'){

	$arFilter = Array("IBLOCK_ID" => OFFICE_INFOBLOCK, "ID" => $_REQUEST['OFFICE'], "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array());
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetProperties();
		foreach($arFields['DEVICES']['VALUE'] as $k => $v){
			$ids[] = $v;
		}

		$bankName = $ob->GetFields();
		$bankName = $bankName['NAME'];
	}

}
$arFilter = Array("IBLOCK_ID"=>PRODUCTS_INFOBLOCK, "ID" => $ids, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array());
$ids = Array();
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetProperties();
	if($arFields['SHIPPING_DATE']['VALUE'] > $_REQUEST['DATE_FROM'] && $arFields['SHIPPING_DATE']['VALUE'] < $_REQUEST['DATE_TO']) {
		$arFields = $ob->GetFields();
		$ids[] = $arFields['ID'];
	}
}

global $arrFilter;
$arrFilter = Array("IBLOCK_ID" => PRODUCTS_INFOBLOCK, "ID" => $ids );
if(count($ids) == 0) return;
$_SESSION['ids'] = $ids;
$_SESSION['DATE_FROM'] = $_REQUEST['DATE_FROM'];
$_SESSION['DATE_TO'] = $_REQUEST['DATE_TO'];
if($bankName != '') $_SESSION['OFFICE'] = $bankName;
$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"office_report",
	Array(
		"BANK_NAME" => $bankName,
		"COMPONENT_TEMPLATE" => "office_report",
		"IBLOCK_TYPE" => "Devices",
		"IBLOCK_ID" => "6",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "arrFilter",
		"FIELD_CODE" => array("","ID","CODE","XML_ID","NAME","TAGS","SORT","PREVIEW_TEXT","PREVIEW_PICTURE","DETAIL_TEXT","DETAIL_PICTURE","DATE_ACTIVE_FROM","ACTIVE_FROM","DATE_ACTIVE_TO","ACTIVE_TO","SHOW_COUNTER","SHOW_COUNTER_START","IBLOCK_TYPE_ID","IBLOCK_ID","IBLOCK_CODE","IBLOCK_NAME","IBLOCK_EXTERNAL_ID","DATE_CREATE","CREATED_BY","CREATED_USER_NAME","TIMESTAMP_X","MODIFIED_BY","USER_NAME",""),
		"PROPERTY_CODE" => array("","OWNER","SHIPPING_DATE","MODEL","DELIVERY_NOTE","LOT_NUMBER","BILL_NUMBER","END_OF_WARRANTY","SERIAL_NUMBER","STATUS",""),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "Y",
		"SET_BROWSER_TITLE" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_META_DESCRIPTION" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"TEMPLATE_THEME" => "blue",
		"MEDIA_PROPERTY" => "",
		"SLIDER_PROPERTY" => "",
		"SEARCH_PAGE" => "/search/",
		"USE_RATING" => "N",
		"USE_SHARE" => "N"
	)
);
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>