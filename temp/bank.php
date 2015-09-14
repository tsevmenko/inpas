<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("bank");
CModule::IncludeModule("iblock");
?>

<script>
	$(function(){
		$('#equipmentReportButton').on('click', function(){

			var billNumber = $('#input-search-1').val();

			$.ajax({
				url: "/bitrix/components/yadadya/equipmentReportByBill.php",
				data: { BILL: billNumber }
			}).done(function(res){
				$('#searchResult').html(res);
				$("#searchResult").css('display', 'block');
			});

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
        
        <form id="search">
		<p>Номер счёта</p>
		<div class="row">
			<input type="text" class="input-search-class" id="input-search-1" placeholder="Введи поисковое значение, например:">
			<div class="input-placeholder input-search-1"><a href="#" data-id="input-search-1" data-value="114 512">114 512</a></div>
			<div class="banks-selector">
				<button class="blue-btn" id="equipmentReportButton">Найти</button>
			</div>
			<div class="clear"></div>
		</div>
        </form>
		
		<div class="clear"></div>

		<div id="searchResult" style="display: none;">
        <?
			$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"office_report",
				Array(
					"COMPONENT_TEMPLATE" => "office_report",
					"IBLOCK_TYPE" => "Devices",
					"IBLOCK_ID" => "6",
					"NEWS_COUNT" => "20",
					"SORT_BY1" => "ACTIVE_FROM",
					"SORT_ORDER1" => "DESC",
					"SORT_BY2" => "SORT",
					"SORT_ORDER2" => "ASC",
					"FILTER_NAME" => "",
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
			);?>
		</div>
			
    </div><!-- end content2 -->

</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>