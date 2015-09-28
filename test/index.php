<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
?>
<div class="wrapper2">

	<div class="content2">

		<div class="breadcrumbs">
			<a href="#">Главная</a> <span></span> Все ремонты клиента
		</div>

		<h1>Все ремонты клиента</h1>
		<form id="search">
			<p>Введите клиента</p>
			<div class="row">
				<input type="text" class="input-search-class" id="input-search-1" placeholder="Введите название клиента..." name="CLIENT_BANK_NAME"
				<?if($_REQUEST['CLIENT_BANK_NAME'] != ''):?>
				value="<?=$_REQUEST['CLIENT_BANK_NAME']?>" 
				<?endif;?>>
				<div class="banks-selector">
					<button class="btn-blue">Найти</button>
				</div>
				<div class="clear"></div>
			</div>
		</form>

		<script>
			$(function(){
				$('#search .btn-blue').on('click', function(){
					$("#search").submit();
				});
			});
		</script>

		<div class="clear"></div>
		<div id="resultBlock">
		<?
		if($_REQUEST['CLIENT_BANK_NAME'] != ''){
			$connection = odbc_connect("Driver={SQL Server};Server=10.35.1.48;Database=service-center;Client_CSet=UTF-8",
			"yadadya", "yadadya");
			//Царицынское ОСБ № 7978 СБ РФ
			$query = "select distinct serial_number, equipment_owner from servise_all where equipment_owner = '".$_REQUEST['CLIENT_BANK_NAME']."'";
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
	
			foreach ($ids as $key => $value) {
				global $arrFilter;
				$arrFilter = array("PROPERTY_SERIAL_NUMBER" => $value);
				$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"report-all-fixes",
					Array(
						"BANK_NAME" => $key,
						"COMPONENT_TEMPLATE" => ".default",
						"IBLOCK_TYPE" => "Devices",
						"IBLOCK_ID" => "6",
						"NEWS_COUNT" => "5",
						"SORT_BY1" => "ACTIVE_FROM",
						"SORT_ORDER1" => "DESC",
						"SORT_BY2" => "SORT",
						"SORT_ORDER2" => "ASC",
						"FILTER_NAME" => "arrFilter",
						"FIELD_CODE" => array("","ID","CODE","XML_ID","NAME","TAGS","SORT","PREVIEW_TEXT","PREVIEW_PICTURE","DETAIL_TEXT","DETAIL_PICTURE","DATE_ACTIVE_FROM","ACTIVE_FROM","DATE_ACTIVE_TO","ACTIVE_TO","SHOW_COUNTER","SHOW_COUNTER_START","IBLOCK_TYPE_ID","IBLOCK_ID","IBLOCK_CODE","IBLOCK_NAME","IBLOCK_EXTERNAL_ID","DATE_CREATE","CREATED_BY","CREATED_USER_NAME","TIMESTAMP_X","MODIFIED_BY","USER_NAME",""),
						"PROPERTY_CODE" => array("",""),
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
						"MESSAGE_404" => ""
					)
				);	
			}
		}
		?>
		</div>
	</div><!-- end content2 -->
</div>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>