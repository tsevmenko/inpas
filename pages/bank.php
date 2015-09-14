<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("bank");
?>
<div class="wrapper2">

	<div class="content2">
	
		<div class="breadcrumbs">
			<a href="#">Главная</a> <span></span> <a href="#">Банки</a> <span></span> ОАО Сбербанк филиал Московский
		</div>
		
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.detail", 
			"bankDetail", 
			array(
				"COMPONENT_TEMPLATE" => "bankDetail",
				"IBLOCK_TYPE" => "Offices",
				"IBLOCK_ID" => "10",
				"ELEMENT_ID" => "26093",
				"ELEMENT_CODE" => "",
				"CHECK_DATES" => "Y",
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
					1 => "ORA_ID",
					2 => "ORA_PRFX",
					3 => "LAST_ACTIVITY_DATE",
					4 => "LAST_ACTIVITY",
					5 => "",
				),
				"IBLOCK_URL" => "",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "Y",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_GROUPS" => "Y",
				"SET_TITLE" => "Y",
				"SET_CANONICAL_URL" => "N",
				"SET_BROWSER_TITLE" => "Y",
				"BROWSER_TITLE" => "-",
				"SET_META_KEYWORDS" => "Y",
				"META_KEYWORDS" => "-",
				"SET_META_DESCRIPTION" => "Y",
				"META_DESCRIPTION" => "-",
				"SET_LAST_MODIFIED" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
				"ADD_SECTIONS_CHAIN" => "Y",
				"ADD_ELEMENT_CHAIN" => "N",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"USE_PERMISSIONS" => "N",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"USE_SHARE" => "N",
				"PAGER_TEMPLATE" => ".default",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "Y",
				"PAGER_TITLE" => "Страница",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"SET_STATUS_404" => "N",
				"SHOW_404" => "N",
				"MESSAGE_404" => ""
			),
			false
		);?>
		<?
		if(($_REQUEST['DATE_FROM'] == '' && $_REQUEST['DATE_TO'] == '') || ($_REQUEST['DATE_FROM'] == 'none' && $_REQUEST['DATE_TO'] == 'none')){
			$_REQUEST['DATE_FROM'] = date("d.m.Y");
			$_REQUEST['DATE_TO'] = date("d.m.Y");
		}
		global $arrFilter;
// for test
$_REQUEST['DATE_TO'] = "23.04.2011";
$_REQUEST['DATE_FROM'] = "20.04.2011";

		$arrFilter = array (
			array(
				"LOGIC" => "AND",
				array("PROPERTY_SERIAL_NUMBER" => $_SESSION['devices']),
				// по спецификации изначально показываем все аппараты банка
				//array("<PROPERTY_SHIPPING_DATE" => date("Y-m-d 00:00:00", strtotime($_REQUEST['DATE_TO']))),
				//array(">PROPERTY_SHIPPING_DATE" => date("Y-m-d 00:00:00", strtotime($_REQUEST['DATE_FROM']))),
				//array("<PROPERTY_END_OF_WARRANTY" => date('Y-m-d 00:00:00', time()))
			),
		);
?><div id="warrantyBlock"><?
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
		</div>
		<div class="clear"></div>
	
	</div><!-- end content2 -->
	

</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>