<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

require_once 'Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Yadadya")
                ->setLastModifiedBy("Yadadya")
                ->setTitle("Office MS")
                ->setSubject("Office MS")
                ->setDescription("PHPExcel file")
                ->setKeywords("some text words")
                ->setCategory("category");
$objPHPExcel->getActiveSheet()->setTitle('sheet1');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Привееееееееееееееееееееет');
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', 'Мир!');

 foreach(range('A','AA') as $columnID) {
		$objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
			->setAutoSize(true);
	}

require_once 'Classes/PHPExcel/IOFactory.php';
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// Если вы хотите, то можете сохранить в другом формате, например, PDF:
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
//$objWriter->save('MyExcel.xlsx');

header('Content-Type: application/vnd.ms-excel');
header('Cache-Control: max-age=0');
header('Content-Disposition: attachment; filename="MyExcel.xlsx"');

$objWriter->save('php://output');

//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>