<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<div class="wrapper2">

	<div class="content2">
	
		<div class="breadcrumbs">
			<a href="#">Главная</a> <span></span> Генерирование отчета по номеру счета
		</div>
		
		<h1>Генерирование отчета по номеру счета</h1>
		
		<form id="search" method="post" enctype="multipart/form-data">
			<input type="hidden" name="SEND" value="Y" />
			<div class="report-serial">
				<div class="col-1" id="taginput">
					<p>Введите через запятую серийные номера</p>
					<input type="text" class="serial" name="serial_numbers" value="<?=$_REQUEST['serial_numbers']?>" data-role="tagsinput"  placeholder="8685. 5512">
				</div>
				<div class="col-2">
					<p>или загрузите файл с серийными номерами</p>
					<div class="button-file-input">
						<input type="text" readonly class="serial">
						<label>Выбрать
							<input type="file" name="files">
						</label>						
					</div>					
				</div>
				<div class="col-3">
					<button class="btn-blue">Сгенерировать отчёт</button>
				</div>
				<div class="clear"></div>
			</div>
		</form>
		
		<?if($_REQUEST['SEND'] == "Y"):?>
		<?
			$ids = Array();

			global $arrFilter;
			$arrFilter = array();

			$path = $_SERVER['DOCUMENT_ROOT']."/upload/tmp/".generateRandomString().$_FILES['files']['name'];//[count($_FILES['files']['name'])-1];
			
			move_uploaded_file($_FILES['files']['tmp_name'], $path);

			switch($_FILES['files']['type']){

				case "text/plain":
					$text = file_get_contents($path);
					$ids = split(',', $text);
				break;
				case "application/vnd.ms-excel": 
				case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":

					$exe = $_FILES['files']['name'];
					$exe = substr($exe, strpos($exe, '.')+1);

					if($exe == 'csv'){
						$text = file_get_contents($path);
						$ids = split(';', $text);
					}
					else{

						require_once $_SERVER['DOCUMENT_ROOT'].'/phpexcel/Classes/PHPExcel/IOFactory.php';
						$objPHPExcel = PHPExcel_IOFactory::load($path);

						foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
						{
							$worksheetTitle     = $worksheet->getTitle();
							$highestRow         = $worksheet->getHighestRow();
							$highestColumn      = $worksheet->getHighestColumn();
							$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
							$nrColumns = ord($highestColumn) - 64;
							for ($row = 1; $row <= $highestRow; ++ $row)
							{
								for ($col = 0; $col < $highestColumnIndex; ++ $col) 
								{
									$cell = $worksheet->getCellByColumnAndRow($col, $row);
									$val = $cell->getValue();
									if($val != '') $ids[] = $val;
								}
							}
						}
					}

				break;
				//default: $ids = split(',', str_replace(', ', ',', $_REQUEST['text']));
			}
			if($_REQUEST['serial_numbers'] != ''){

				$_REQUEST['serial_numbers'] = str_replace(' ', '', $_REQUEST['serial_numbers']);
				if(strpos($_REQUEST['serial_numbers'], ',') > 0){
					$_REQUEST['serial_numbers'] = explode(',', $_REQUEST['serial_numbers']);
					foreach ($_REQUEST['serial_numbers'] as $key => $value) {
						if($value != '') $ids[] = $value;
					}
				}
				else{
					$ids[] = $_REQUEST['serial_numbers'];
				}
			}
			$arrFilter["PROPERTY_SERIAL_NUMBER"] = $ids;
			$ids = implode(', ', $ids);
		?>

		<h5 class="left">Серийные номера: <span><?=$ids?></span></h5>
		<?
		$APPLICATION->IncludeComponent(
			"bitrix:news.list", 
			"report-serial-number", 
			array(
				"COMPONENT_TEMPLATE" => "report-serial-number",
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
		);
		endif;
		?>


			
    </div><!-- end content2 -->

</div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>