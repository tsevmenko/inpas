<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отгруженное оборудование");
CModule::IncludeModule("iblock");
?>

<script>
	$(function(){
		$('#equipmentReportButton').on('click', function(){
			var dateFrom = $('#date-pick-1').val();
			var dateTo = $('#date-pick-2').val();
			var bank = $('#bank-1-variants-sel option').val();
			var office = $('#bank-2-variants-sel option').val();

			$.ajax({
				url: "/bitrix/components/yadadya/equipmentReport.php",
				data: { DATE_FROM: dateFrom, DATE_TO: dateTo, BANK: bank, OFFICE: office }
			}).done(function(res){
				$('#searchResult').html(res);
				$('#searchResult').css("display", 'block');
			});

			return false;
		});
	});
</script>

<div class="wrapper2">

	<div class="content2">

        <div class="breadcrumbs">
			<a href="/">Главная</a> <span></span> Генерирование отчета по отгруженному оборудованию
        </div>

    </div><!-- end content2 --> 

    <div class="content3">
        <h1>Генерирование отчета по отгруженному оборудованию</h1>

        <form id="search1">
			<div class="row">
				<div class="banks-selector">
					<div class="col col-1">
						<p>Выберите банк (поддерживается произвольный ввод)</p>
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
						  	<?}?>
						</select>
					</div>

					<div class="col col-2">
						<p>Выберите филиал банка</p>
						<select id="bank-2-variants-sel" placeholder="Введите название банка...">
							<option value="none">Введите название банка...</option>
							<?
								$arSelect = Array("ID", "NAME", "CODE");
								$arFilter = Array("IBLOCK_ID" => OFFICE_INFOBLOCK, "ACTIVE" => "Y");
								$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

								while($ob = $res->GetNextElement())
								{
									$arFields = $ob->GetFields();?>
									<option value="<?=$arFields['ID']?>"><?=$arFields['NAME']?></option>
						  	<?}?>
						</select>
					</div>

					<div class="period-selectors-wrapper" id="bank-periods">
						<div class="col col-1">
							<div class="lbl">Дата отгрузки от</div>
							<div class="date-selector-wrapper"><input type="text" id="date-pick-1" value="<?=date('d.m.Y')?>"><button></button></div>
						</div>
						<div class="col col-2">
							<div class="lbl">Дата отгрузки от</div>
							<div class="date-selector-wrapper"><input type="text" id="date-pick-2" value="<?=date('d.m.Y')?>"><button></button></div>
						</div>
						<div class="col col-3">
							<button class="date-clear"></button>
						</div>
					</div>

					<div class="col col-4">
						<button class="blue-btn" id="equipmentReportButton">Найти</button>
					</div>

					<div class="clear"></div>

				</div>

			</div>
        </form>

        <div class="clear"></div>

        </div><!-- end content3 -->

	<div class="content2" id="searchResult" style="display: none;">

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
    	</div><!-- end content2 -->

	<div class="clear"></div>

</div><!-- end wrapper2 -->

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>