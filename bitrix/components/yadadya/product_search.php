<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?

$ids = Array();

global $arrFilter;
$arrFilter = Array();

$path = $_SERVER['DOCUMENT_ROOT']."/upload/tmp/".generateRandomString().$_FILES['files']['name'][count($_FILES['files']['name'])-1];

move_uploaded_file($_FILES['files']['tmp_name'][count($_FILES['files']['name'])-1], $path);

switch($_FILES['files']['type'][count($_FILES['files']['type'])-1]){

	case "text/plain":
		$text = file_get_contents($path);
		$ids = split(',', $text);
	break;
	case "application/vnd.ms-excel": 
	case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":

		$exe = $_FILES['files']['name'][count($_FILES['files']['name'])-1];
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
	default: $ids = split(',', str_replace(', ', ',', $_REQUEST['text']));
}

$arrFilter["PROPERTY_SERIAL_NUMBER"] = $ids;

$APPLICATION->IncludeComponent(
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
		"FILTER_NAME" => "arrFilter",
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
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>