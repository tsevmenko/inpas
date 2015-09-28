<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

require_once 'Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Yadadya")
                ->setLastModifiedBy("Yadadya")
                ->setTitle("ShippingEquipmentReport")
                ->setSubject("INPAS")
                ->setDescription("Equipment report")
                ->setCategory("Report");
$objPHPExcel->getActiveSheet()->setTitle('sheet1');

$arFilter = Array("IBLOCK_ID"=>PRODUCTS_INFOBLOCK, "ACTIVE"=>"Y", "ID" => $_SESSION['otchet-po-nomeru-scheta']);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array());
unset($_SESSION['otchet-po-nomeru-scheta']);

/*
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Период: ");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "с ".$_SESSION['DATE_FROM']);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "по ".$_SESSION['DATE_TO']);
if($_SESSION['OFFICE'] != '') {
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "отделение ");
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', $_SESSION['DATE_TO']);
}
*/

$objPHPExcel->getActiveSheet()->getStyle('A1:E256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("A3:E3")->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle("B1:C1")->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', "Наименование");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B3', "Серийный номер");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Дата отгрузки");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D3', "Окончание гарантии");
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E3', "Статус по сервису");
$i = 4;
while($ob = $res->GetNextElement())
{
    $arFields = $ob->GetFields();
    $arProps = $ob->GetProperties();
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $arFields['NAME']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $arProps['SERIAL_NUMBER']['VALUE']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $arProps['SHIPPING_DATE']['VALUE']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $arProps['END_OF_WARRANTY']['VALUE']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $arProps['STATUS']['VALUE']);
    $i++;
}

foreach(range('A','L') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

require_once 'Classes/PHPExcel/IOFactory.php';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

header('Content-Type: application/vnd.ms-excel');
header('Cache-Control: max-age=0');
header('Content-Disposition: attachment; filename="MyExcel.xlsx"');

$objWriter->save('php://output');

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>