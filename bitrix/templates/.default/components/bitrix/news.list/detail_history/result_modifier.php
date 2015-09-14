<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

foreach($arResult['ITEMS'] as $k => $v){

	$arFilter = Array("ID" => $v['PROPERTIES']['COMMENTS']['VALUE'], "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, Array());
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$comm = array();
		$comm['NAME'] = $arFields['NAME'];
		$comm['DATE'] = $arFields['ACTIVE_FROM'];
		$comm['TEXT'] = $arFields['PREVIEW_TEXT'];
		$arResult['ITEMS'][$k]['COMMENTS'][] = $comm;
	}

}

?>