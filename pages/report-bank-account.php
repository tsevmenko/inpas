<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("report-all-fixes");
?>

<div class="wrapper2">

	<div class="content2">
	
		<div class="breadcrumbs">
			<a href="#">Главная</a> <span></span> Генерирование отчета по номеру счета
		</div>
		
		<h1>Генерирование отчета по номеру счета</h1>
		
		<form id="search" action="">
			<p>Номер счёта</p>
			<div class="row">
				<input type="text" name="BILL_NUMBER" class="input-search-class" id="input-search-1" placeholder="Введи поисковое значение, например:"
				<?if($_REQUEST['BILL_NUMBER'] != ''):?>value="<?=$_REQUEST['BILL_NUMBER']?>"<?endif;?>>
				<div class="input-placeholder input-search-1"><a href="#" data-id="input-search-1" data-value="114 512">114 512</a></div>
				<div class="banks-selector">
					<button class="btn-blue">Найти</button>
				</div>
				<div class="clear"></div>
			</div>
		</form>
		<script type="text/javascript">
			$(function(){
				$("#search btn-blue").on('click', function(){
					$("#search").submit();
				});
			});
		</script>
		<div class="clear"></div>
		<?if($_REQUEST['BILL_NUMBER'] != ''):?>
		<?	
				global $arrFilter;
				$arrFilter = array("PROPERTY_BILL_NUMBER" => $_REQUEST['BILL_NUMBER']);
				$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"report-bank-account", 
	array(
		"BANK_NAME" => $key,
		"COMPONENT_TEMPLATE" => "report-bank-account",
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
			?>
		<?endif;?>
			
    </div><!-- end content2 -->

</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>