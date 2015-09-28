<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
function xlsBOF() {
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
	return;
}

function xlsEOF() {
	echo pack("ss", 0x0A, 0x00);
	return;
}

function xlsWriteNumber($Row, $Col, $Value) {
	echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
	echo pack("d", $Value);
	return;
}

function xlsWriteLabel($Row, $Col, $Value ) {
	$L = strlen($Value);
	echo pack("SSSSSS", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
	return;
}

if($_REQUEST['productReport'] == "Y"){

	CModule::IncludeModule("iblock");
	$arFilter = Array("IBLOCK_ID"=>PRODUCTS_INFOBLOCK, "ID" => 37);
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array());
	while($ob = $res->GetNextElement())
	{ 
		$arResult = $ob->GetProperties();
		break;
	}

	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");
	header("Content-Disposition: attachment;filename=list.xls"); 
	header("Content-Transfer-Encoding: binary");
	xlsBOF();

	if($_REQUEST['type'] == "getReport"){

		xlsWriteLabel(0, 0, iconv("utf-8", "windows-1251", "Владелец"));
		xlsWriteLabel(1, 0, iconv("utf-8", "windows-1251", "Дата отгрузки"));
		xlsWriteLabel(2, 0, iconv("utf-8", "windows-1251", "Окончание гарантии"));
		xlsWriteLabel(3, 0, iconv("utf-8", "windows-1251", "Номер счета"));
		xlsWriteLabel(4, 0, iconv("utf-8", "windows-1251", "Номер накладной"));
		xlsWriteLabel(5, 0, iconv("utf-8", "windows-1251", "Статус"));
		xlsWriteLabel(0, 1, iconv("utf-8", "windows-1251", $arResult['OWNER']['VALUE']));
		xlsWriteLabel(1, 1, iconv("utf-8", "windows-1251", $arResult['SHIPPING_DATE']['VALUE']));
		xlsWriteLabel(2, 1, iconv("utf-8", "windows-1251", $arResult['WARRANTY']));
		xlsWriteLabel(3, 1, iconv("utf-8", "windows-1251", $arResult['BILL_NUMBER']['VALUE']));
		xlsWriteLabel(4, 1, iconv("utf-8", "windows-1251", $arResult['BILL_NUMBER']['VALUE']));
		xlsWriteLabel(5, 1, iconv("utf-8", "windows-1251", $arResult['STATUS']['VALUE']));

	}
	xlsEOF(); 
	return false;
}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>