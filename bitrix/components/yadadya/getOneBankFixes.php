<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
if($_REQUEST['SELECTED_CLIENT_NAME'] != ''){

	$connection = odbc_connect("Driver={SQL Server};Server=10.35.1.48;Database=service-center;Client_CSet=UTF-8",
	"yadadya", "yadadya");
	//Царицынское ОСБ № 7978 СБ РФ
	$query = "select distinct serial_number, equipment_owner from servise_all where equipment_owner = '".$_REQUEST['SELECTED_CLIENT_NAME']."'";
	$query = iconv(mb_detect_encoding($query, mb_detect_order(), true), "windows-1251", $query);
	$result = odbc_exec($connection, $query);
	$ids = array();
	while(odbc_fetch_row($result)){

		$odbc_res = odbc_result($result, 2);
		$name = iconv(mb_detect_encoding($odbc_res, mb_detect_order(), true), "UTF-8", $odbc_res);
		$odbc_res = odbc_result($result, 1);
		$val = iconv(mb_detect_encoding($odbc_res, mb_detect_order(), true), "UTF-8", $odbc_res);

		$ids[$name][] = str_replace("-", "", $val);
	}
	odbc_close($connection);
	//return false;
	foreach ($ids as $key => $value) {
		global $arrFilter;
		$arrFilter = array("PROPERTY_SERIAL_NUMBER" => $value);
		$APPLICATION->IncludeComponent(
			"bitrix:news.list", 
			"report-all-fixes", 
			array(
				"BANK_NAME" => $key,
				"COMPONENT_TEMPLATE" => "report-all-fixes",
				"IBLOCK_TYPE" => "Devices",
				"IBLOCK_ID" => "6",
				"NEWS_COUNT" => "10",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "arrFilter",
				"FIELD_CODE" => array(
					0 => "",
					1 => "ID",
					2 => "CODE",
					3 => "XML_ID",
					4 => "NAME",
					5 => "TAGS",
					6 => "SORT",
					7 => "PREVIEW_TEXT",
					8 => "PREVIEW_PICTURE",
					9 => "DETAIL_TEXT",
					10 => "DETAIL_PICTURE",
					11 => "DATE_ACTIVE_FROM",
					12 => "ACTIVE_FROM",
					13 => "DATE_ACTIVE_TO",
					14 => "ACTIVE_TO",
					15 => "SHOW_COUNTER",
					16 => "SHOW_COUNTER_START",
					17 => "IBLOCK_TYPE_ID",
					18 => "IBLOCK_ID",
					19 => "IBLOCK_CODE",
					20 => "IBLOCK_NAME",
					21 => "IBLOCK_EXTERNAL_ID",
					22 => "DATE_CREATE",
					23 => "CREATED_BY",
					24 => "CREATED_USER_NAME",
					25 => "TIMESTAMP_X",
					26 => "MODIFIED_BY",
					27 => "USER_NAME",
					28 => "",
				),
				"PROPERTY_CODE" => array(
					0 => "",
					1 => "MS_ACTION_TIMESTAMP",
					2 => "MS_MAIN_STATUS",
					3 => "NAME_ORACLE",
					4 => "MS_SUBMIT_DATE",
					5 => "BROKEN",
					6 => "OWNER",
					7 => "SHIPPING_DATE",
					8 => "HISTORY",
					9 => "MODEL",
					10 => "DELIVERY_NOTE",
					11 => "LOT_NUMBER",
					12 => "BILL_NUMBER",
					13 => "END_OF_WARRANTY",
					14 => "SERIAL_NUMBER",
					15 => "STATUS",
					16 => "TYPE",
					17 => "",
				),
				"CHECK_DATES" => "Y",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "Y",
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
				"PAGER_TEMPLATE" => "history_pagination",
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
				"MESSAGE_404" => ""
			),
			false
		);	
	}
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>