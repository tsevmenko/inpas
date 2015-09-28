<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отчет по номеру счета");
CModule::IncludeModule("iblock");
?>

<script>
	$(function(){
		$('#equipmentReportButton').on('click', function(){
			$('#search').submit();
			/*var billNumber = $('#input-search-1').val();

			$.ajax({
				url: "/bitrix/components/yadadya/equipmentReportByBill.php",
				data: { BILL: billNumber }
			}).done(function(res){
				$('#searchResult').html(res);
				$("#searchResult").css('display', 'block');
			});*/

			return false;
		});
	});
</script>

<div class="wrapper2">

	<div class="content2">
	
        <div class="breadcrumbs">
            <a href="#">Главная</a> <span></span> Генерирование отчета по номеру счета
        </div>
        
        <h1>Генерирование отчета по номеру счета</h1>
        
        <form id="search" action="">
			<p>Номер счёта</p>
			<div class="row">
				<input type="text" value="<?if($_REQUEST['BILL'] != '') echo $_REQUEST['BILL']?>" name="BILL" class="input-search-class" id="input-search-1" placeholder="Введи поисковое значение, например:">
				<input type="hidden" name="SEND" value="Y"/>
				<div class="input-placeholder input-search-1"><a href="#" data-id="input-search-1" data-value="70127">70127</a></div>
				<div class="banks-selector">
					<button class="btn-blue" id="equipmentReportButton">Найти</button>
				</div>
				<div class="clear"></div>
			</div>
        </form>
		
		<div class="clear"></div>

        <?
        	if($_REQUEST['SEND'] == "Y"){
				global $arrFilter;
				if(strpos($_REQUEST['BILL'], ',') > 0){
					$_REQUEST['BILL'] = str_replace(' ', '', $_REQUEST['BILL']);
					$_REQUEST['BILL'] = explode(',', $_REQUEST['BILL']);
				}

				$arrFilter = Array("IBLOCK_ID" => PRODUCTS_INFOBLOCK, "PROPERTY_BILL_NUMBER" => $_REQUEST['BILL']);

				$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"office_report_by_bill", 
	array(
		"BANK_NAME" => $bankName,
		"COMPONENT_TEMPLATE" => "office_report_by_bill",
		"IBLOCK_TYPE" => "Devices",
		"IBLOCK_ID" => "6",
		"NEWS_COUNT" => "20",
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
			0 => "OWNER",
			1 => "SHIPPING_DATE",
			2 => "MODEL",
			3 => "DELIVERY_NOTE",
			4 => "LOT_NUMBER",
			5 => "BILL_NUMBER",
			6 => "END_OF_WARRANTY",
			7 => "SERIAL_NUMBER",
			8 => "STATUS",
			9 => "",
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
		"MESSAGE_404" => "",
		"TEMPLATE_THEME" => "blue",
		"MEDIA_PROPERTY" => "",
		"SLIDER_PROPERTY" => "",
		"SEARCH_PAGE" => "/search/",
		"USE_RATING" => "N",
		"USE_SHARE" => "N"
	),
	false
);}?>
			
    </div><!-- end content2 -->

</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>