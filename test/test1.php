<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

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
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
	return;
}

header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
header("Content-Disposition: attachment;filename=list.xls"); 
header("Content-Transfer-Encoding: binary");

$name = iconv("utf-8", "windows-1251", "Название");

xlsBOF(); //начинаем собирать файл
/*первая строка*/
xlsWriteLabel(1,0, $name);
/*вторая строка*/
xlsWriteLabel(2,0,"№п/п");
xlsWriteLabel(2,1,"Имя");
xlsWriteLabel(2,2,"Фамилия");
/*третья строка*/
xlsWriteNumber(3,0,"1");
xlsWriteLabel(3,1,"Петр");
xlsWriteLabel(3,2,"Иванов");
/*...*/
xlsWriteNumber(32,0,"30");
xlsWriteLabel(32,1,"Иван");
xlsWriteLabel(32,2,"Петров");

xlsEOF(); //заканчиваем собирать

//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>