<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("INPAS");
CModule::IncludeModule("iblock");
?>
<script>
$(function(){
	$('#content2').css('display', 'none');
	$('#searchBankButton').on('click', function(){
		$('#content1').css('display', 'block');
		$('#content2').css('display', 'none');
		$('#lastActivityWrapper').css('display', 'block');
	});

	$('#searchProductButton').on('click', function(){
		$('#content1').css('display', 'none');
		$('#content2').css('display', 'block');
		$('#lastActivityWrapper').css('display', 'none');
	});
});
</script>
<div class="wrapper">
	<div class="content">
		<div class="tabs">
 	<input id="tab1" type="radio" name="tabs" checked=""> 
	<label for="tab1" id="searchBankButton">Поиск по банку</label> 
	<input id="tab2" type="radio" name="tabs"> 
	<label for="tab2" id="searchProductButton">Поиск по товару</label> 

<section id="content1">
	<div class="inner">
		<form id="search" class="bank-block">
			<div class="row">
				<input type="text" class="input-search-class" id="input-search-1" placeholder="Введи поисковое значение, например:">
				<div class="input-placeholder input-search-1"><a href="#" data-id="input-search-1" data-value="Сбербанк">сбербанк</a></div>
			</div>
			<div class="row">
				<div class="banks-selector">
					<div class="col col-1">
						<select id="bank-1-variants-sel" placeholder="Введите название банка...">
							<option value="none">Введите название банка...</option>
							<?
								$arSelect = Array("ID", "NAME", "CODE");
								$arFilter = Array("IBLOCK_ID" => BANK_INFOBLOCK, "ACTIVE" => "Y");
								$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

								while($ob = $res->GetNextElement())
								{
									$arFields = $ob->GetFields();?>
									<option value="<?=$arFields['ID']?>"><?=$arFields['NAME']?></option>
						  	  <?}
						  	?>
						</select>
					</div>

					<div class="col col-2">
						<select id="bank-2-variants-sel" placeholder="Введите регион...">
							<option value="none">Введите регион...</option>
							<?
								$arSelect = Array("ID", "NAME", "CODE");
								$arFilter = Array("IBLOCK_ID" => REGION_INFOBLOCK, "ACTIVE" => "Y");
								$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

								while($ob = $res->GetNextElement())
								{
									$arFields = $ob->GetFields();?>
									<option value="<?=$arFields['ID']?>"><?=$arFields['NAME']?></option>
						  	  <?}
						  	?>
						</select>
					</div>
					<div class="col col-3">
						<button class="btn-blue">Найти</button>
					</div>
					<div class="clear"></div>
				</div>

			</div>
		</form>
		<div class="alpha bank-letters">
			<div class="letters">
				<a href="#">А</a>
				<a href="#">Б</a>
				<a href="#">В</a>
				<a href="#">Г</a>
				<a href="#">Д</a>
				<a href="#">Е</a>
				<a href="#">Ж</a>
				<a href="#">З</a>
				<a href="#">И</a>
				<a href="#">Й</a>
				<a href="#">К</a>
				<a href="#">Л</a>
				<a href="#">М</a>
				<a href="#">Н</a>
				<a href="#">О</a>
				<a href="#">П</a>
				<a href="#">Р</a>
				<a href="#">С</a>
				<a href="#">Т</a>
				<a href="#">У</a>
				<a href="#">Ф</a>
				<a href="#">Х</a>
				<a href="#">Ц</a>
				<a href="#">Ч</a>
				<a href="#">Э</a>
				<a href="#">Ю</a>
				<a href="#">Я</a>
			</div>
			<div class="all-banks">
				<a href="#">Все банки</a>
			</div>
		</div>
	</div>
	<div id="all-banks-table-div">
	<?$APPLICATION->IncludeComponent(
		"bitrix:news.list",
		"bank_search",
		Array(
			"COMPONENT_TEMPLATE" => "bank_search",
			"IBLOCK_TYPE" => "Offices",
			"IBLOCK_ID" => "10",
			"NEWS_COUNT" => "7",
			"SORT_BY1" => "",
			"SORT_ORDER1" => "",
			"SORT_BY2" => "",
			"SORT_ORDER2" => "",
			"FILTER_NAME" => "",
			"FIELD_CODE" => array("ID","CODE","XML_ID","NAME","TAGS","SORT","PREVIEW_TEXT","PREVIEW_PICTURE","DETAIL_TEXT","DETAIL_PICTURE","DATE_ACTIVE_FROM","ACTIVE_FROM","DATE_ACTIVE_TO","ACTIVE_TO","SHOW_COUNTER","SHOW_COUNTER_START","IBLOCK_TYPE_ID","IBLOCK_ID","IBLOCK_CODE","IBLOCK_NAME","IBLOCK_EXTERNAL_ID","DATE_CREATE","CREATED_BY","CREATED_USER_NAME","TIMESTAMP_X","MODIFIED_BY","USER_NAME",""),
			"PROPERTY_CODE" => array("","OWNER","SHIPPING_DATE","MODEL","DELIVERY_NOTE","BILL_NUMBER","END_OF_WARRANTY","SERIAL_NUMBER","STATUS",""),
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
		)
	);?> 
	</div>
</section> 
<section id="content2">
	<div class="inner">
		<form id="search" class="device-block" enctype="multipart/form-data">
			<div class="row">
				<input type="text" name="searchtext" class="input-search-class" id="input-search-2" placeholder="Введи серийные номера, например:">
				<div class="input-placeholder input-search-2">
					<a href="#" data-id="input-search-2" data-value="154 901">154 901</a>
				</div>
			</div>
			<div class="row">
				<div class="help-line">
					 или загрузите файл с серийными номерами
				</div>
				<label class="input-file" for="input-file">Выбрать</label> <input type="file" name="file-serials" id="input-file" class="input-file-hidden">
				<div class="btn-col">
					<button class="blue-btn">Найти</button>
				</div>
				<div class="clear"></div>
			</div>
		</form>
	</div>
	<div class="all-banks-block" id="all-banks-table-div-device">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"product_search",
			Array(
				"COMPONENT_TEMPLATE" => "product_search",
				"IBLOCK_TYPE" => "Devices",
				"IBLOCK_ID" => "6",
				"NEWS_COUNT" => "3",
				"SORT_BY1" => "",
				"SORT_ORDER1" => "",
				"SORT_BY2" => "",
				"SORT_ORDER2" => "",
				"FILTER_NAME" => "",
				"FIELD_CODE" => array("ID","CODE","XML_ID","NAME","TAGS","SORT","PREVIEW_TEXT","PREVIEW_PICTURE","DETAIL_TEXT","DETAIL_PICTURE","DATE_ACTIVE_FROM","ACTIVE_FROM","DATE_ACTIVE_TO","ACTIVE_TO","SHOW_COUNTER","SHOW_COUNTER_START","IBLOCK_TYPE_ID","IBLOCK_ID","IBLOCK_CODE","IBLOCK_NAME","IBLOCK_EXTERNAL_ID","DATE_CREATE","CREATED_BY","CREATED_USER_NAME","TIMESTAMP_X","MODIFIED_BY","USER_NAME",""),
				"PROPERTY_CODE" => array("","OWNER","SHIPPING_DATE","MODEL","DELIVERY_NOTE","BILL_NUMBER","END_OF_WARRANTY","SERIAL_NUMBER","STATUS",""),
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
			)
		);?> 
		</div>
 </section>
		</div>
	</div>
</div>
<div class="sidebar" id="lastActivityWrapper">
	<?$APPLICATION->IncludeComponent(
		"yadadya:last.activity",
		"",
		Array());?>
</div>
<div class="clear"></div>

<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>