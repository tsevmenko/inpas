<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Отгруженное оборудование");
CModule::IncludeModule("iblock");

$banks = array();
$offices = array();
$models = array();
$borel = array(); // bank & offices relationship
// get all banks
$arSelect = Array("ID", "NAME", "CODE");
$arFilter = Array("IBLOCK_ID"=>11, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNext())
{
	switch ($ob['CODE']) {
		case 'sbrf':
				$banks[$ob['CODE']] = "Сбербанк";
			break;
		
		default:
				$banks[$ob['CODE']] = "Другое";		
			break;
	}
}
// get all offices
$arSelect = Array("ID", "NAME", "CODE", "PROPERTY_ORA_ID", "PROPERTY_ORA_PRFX");
$arFilter = Array("IBLOCK_ID"=>10, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNext())
{
	$offices[$ob['PROPERTY_ORA_ID_VALUE']] = array($ob['NAME'], $ob['PROPERTY_ORA_PRFX_VALUE']);
	if($ob['PROPERTY_ORA_PRFX_VALUE'] == '') $ob['PROPERTY_ORA_PRFX_VALUE'] = 'another';
	$borel[$ob['PROPERTY_ORA_PRFX_VALUE']][] = $ob['PROPERTY_ORA_ID_VALUE'];
}
?>
<script>
	$(function(){
		$('#bank-periods .date-clear').on('click', function(){
			$('#date-pick-1').val('');
			$('#date-pick-2').val('');
		});
		/*$('#equipmentReportButton').on("click", function(){
			$('#search1').submit();
		});*/
		/*$('#equipmentReportButton').on('click', function(){
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
		});*/

		/*$.ajax({
			url: "/bitrix/components/yadadya/reportSendEquipmentHeader.php"
		}).done(function(res){
			$('#ajaxUpload').html(res);
		});*/
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
					<div id="ajaxUpload">
					<div class="col col-1">
						<p>Выберите банк (поддерживается произвольный ввод)</p>
						<select name="bank_name" id="bank-1-variants-sel" placeholder="Введите название банка...">
							<option value="none">Введите название банка...</option>
							<?foreach ($banks as $key => $value):?>
								<option value="<?=$key?>" <?if($_REQUEST['bank_name'] == $key) echo ' selected ';?>><?=$value?></option>	
							<?endforeach?>
						</select>
					</div>

					<div class="col col-2">
						<p>Выберите филиал банка</p>
						<select name="office_name" id="bank-2-variants-sel" placeholder="Введите название банка...">
							<option value="none">Введите название банка...</option>
							<?foreach ($offices as $key => $value):?>
								<option value="<?=$key?>" <?if($_REQUEST['office_name'] == $key) echo ' selected ';?>><?=$value[0]?></option>	
							<?endforeach?>	
						</select>
					</div>
					</div>
					<div class="period-selectors-wrapper" id="bank-periods">
						<div class="col col-1">
							<div class="lbl">Дата отгрузки от</div>
							<div class="date-selector-wrapper"><input type="text" name="DATE_FROM" id="date-pick-1" value="<?=$_REQUEST['DATE_FROM']?>"><button></button></div>
						</div>
						<div class="col col-2">
							<div class="lbl">Дата отгрузки от</div>
							<div class="date-selector-wrapper"><input type="text" name="DATE_TO" id="date-pick-2" value="<?=$_REQUEST['DATE_TO']?>"><button></button></div>
						</div>
						<div class="col col-3">
							<button class="date-clear"></button>
						</div>
					</div>

					<div class="col col-4">
						<button class="btn-blue" id="equipmentReportButton">Найти</button>
					</div>

					<div class="clear"></div>

				</div>

			</div>
			<input type="hidden" name="SEND" value="Y"/>
        </form>

        <div class="clear"></div>

        </div><!-- end content3 -->
	
			<?if($_REQUEST['SEND'] == 'Y'):?>
			<div class="content2" id="searchResult">
			<?
				CModule::IncludeModule("iblock");
				//$_REQUEST['SERIAL_NUMBER'] = 210409879;
				global $arrFilter;
				$arrFilter = array();
				$filter = array("LOGIC" => "AND");

				if($_REQUEST['DATE_TO'] != ''){
					$filter["<PROPERTY_SHIPPING_DATE"] = date("Y-m-d 00:00:00", strtotime($_REQUEST['DATE_TO']));
				}
				if($_REQUEST['DATE_FROM'] != ''){
					$filter[">PROPERTY_SHIPPING_DATE"] = date("Y-m-d 00:00:00", strtotime($_REQUEST['DATE_FROM']));
				}
				if($_REQUEST['bank_name'] != ''){
					// get owners list
					$owners = array();

					if($_REQUEST['office_name'] == ''){
						// get all offices in this bank
						$arSelect = Array("ID");
						$arFilter = Array("IBLOCK_ID"=>10, "PROPERTY_ORA_PRFX" => $_REQUEST['bank_name']);
						$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
						while($ob = $res->GetNext())
						{
							$owners[] = $ob['ID'];
						}
						$arSelect = array("ID", "IBLOCK_ID", "PROPERTY_ORA_ID");
						$arFilter = Array("IBLOCK_ID"=>10, "ID" => $owners);
						$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
						$ids = array();
						while($ob = $res->GetNext())
						{
							$ids[] = $ob['PROPERTY_ORA_ID_VALUE'];
						}
						$owners = $ids;
					}
					else{
						// set this office as filter value
						$owners[] = $_REQUEST['office_name'];
					}
					// add owners to filter
					$arrFilter['PROPERTY_OWNER'] = $owners;
				}

				$arrFilter[] = $filter;

			$APPLICATION->IncludeComponent(
				"bitrix:news.list", 
				"office_report", 
				array(
					"COMPONENT_TEMPLATE" => "office_report",
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
    	</div><!-- end content2 -->
    	<?endif;?>

	<div class="clear"></div>

</div><!-- end wrapper2 -->
<script type="text/javascript">
	// saving here relationship between banks and offices
	var borel = JSON.parse('<?=json_encode($borel)?>');
	$(function(){
		<?if($_REQUEST['office_name'] != ''):?>
			$("#bank-2-variants-selrb").prop('disabled', false);
		<?endif;?>
		<?if($_REQUEST['device_model'] != ''):?>
			$("#bank-3-variants-selrb").prop('disabled', false);
		<?endif;?>	
	});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>