<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//$_REQUEST['DATE_TO'] = "23.04.2011";
//	$_REQUEST['DATE_FROM'] = "20.04.2011";

	$conn = ConnectToOracleDB();

	$query = 'SELECT ship.SERIAL_NUM,eq.NAME,ship.CUSTOMER_ID,TO_CHAR( ship.DATA_REG, \'dd.mm.yyyy\' ) as DATA_REG,TO_CHAR( ship.WARRANTY, \'dd.mm.yyyy\' ) as WARRANTY, (SELECT NAME FROM STATUS_HB WHERE ID = ship.STATUS_ID) as STATUS,ship.INVOICE,ship.WAYBILL,eq.PARTNUM,eq.NAME FROM EQUIPMENT_HB eq, TERM_SHIPP ship WHERE eq.PARTNUM = ship.TYPE_EQUIP AND ship.CUSTOMER_ID = \''.$_SESSION['BANKID'].'\' ORDER BY ship.SERIAL_NUM';

	$stid = oracleQueryExecute(ConnectToOracleDB(), $query);

	$_SESSION['devices'] = array();
	while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
		$_SESSION['devices'][] = $row['SERIAL_NUM'];
	}

	$arrFilter = array (
		array(
			"LOGIC" => "AND",
			array("PROPERTY_SERIAL_NUMBER" => $_SESSION['devices']),
			array("<PROPERTY_SHIPPING_DATE" => date("Y-m-d 00:00:00", strtotime($_REQUEST['DATE_TO']))),
			array(">PROPERTY_SHIPPING_DATE" => date("Y-m-d 00:00:00", strtotime($_REQUEST['DATE_FROM']))),
			//array("<PROPERTY_END_OF_WARRANTY" => date('Y-m-d 00:00:00', time()))
		),
	);
	
	$APPLICATION->IncludeComponent(
			"bitrix:news.list", 
			"bank_detail_warranty", 
			array(
				"COMPONENT_TEMPLATE" => "bank_detail_warranty",
				"IBLOCK_TYPE" => "Devices",
				"IBLOCK_ID" => "6",
				"NEWS_COUNT" => "5",
				"SORT_BY1" => "ACTIVE_FROM",
				"SORT_ORDER1" => "DESC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "arrFilter",
				"FIELD_CODE" => array(
					0 => "ID",
					1 => "CODE",
					2 => "XML_ID",
					3 => "NAME",
					4 => "TAGS",
					5 => "SORT",
					6 => "PREVIEW_TEXT",
					7 => "PREVIEW_PICTURE",
					8 => "DETAIL_TEXT",
					9 => "DETAIL_PICTURE",
					10 => "DATE_ACTIVE_FROM",
					11 => "ACTIVE_FROM",
					12 => "DATE_ACTIVE_TO",
					13 => "ACTIVE_TO",
					14 => "SHOW_COUNTER",
					15 => "SHOW_COUNTER_START",
					16 => "IBLOCK_TYPE_ID",
					17 => "IBLOCK_ID",
					18 => "IBLOCK_CODE",
					19 => "IBLOCK_NAME",
					20 => "IBLOCK_EXTERNAL_ID",
					21 => "DATE_CREATE",
					22 => "CREATED_BY",
					23 => "CREATED_USER_NAME",
					24 => "TIMESTAMP_X",
					25 => "MODIFIED_BY",
					26 => "USER_NAME",
					27 => "",
				),
				"PROPERTY_CODE" => array(
					0 => "MS_ACTION_TIMESTAMP",
					1 => "MS_MAIN_STATUS",
					2 => "NAME_ORACLE",
					3 => "MS_SUBMIT_DATE",
					4 => "BROKEN",
					5 => "OWNER",
					6 => "SHIPPING_DATE",
					7 => "HISTORY",
					8 => "MODEL",
					9 => "DELIVERY_NOTE",
					10 => "LOT_NUMBER",
					11 => "BILL_NUMBER",
					12 => "END_OF_WARRANTY",
					13 => "SERIAL_NUMBER",
					14 => "STATUS",
					15 => "TYPE",
					16 => "",
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
				"SET_TITLE" => "N",
				"SET_BROWSER_TITLE" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_LAST_MODIFIED" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
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
				"MESSAGE_404" => "",
				"TEMPLATE_THEME" => "blue",
				"MEDIA_PROPERTY" => "",
				"SLIDER_PROPERTY" => "",
				"SEARCH_PAGE" => "/search/",
				"USE_RATING" => "N",
				"USE_SHARE" => "N"
			),
			false
		);?>

<script src="<?=SITE_TEMPLATE_PATH?>/js/datepicker-ru.js"/>

<script src="<?=SITE_TEMPLATE_PATH?>/js/common.js"/>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php"); ?>