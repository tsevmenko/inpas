<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?

$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/jquery-ui.css');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/style.css');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/tabs.css');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/selectize.css');

$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/bootstrap-tagsinput.css');
?>
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?
CModule::IncludeModule("iblock");

$banks = array();
$offices = array();
$models = array();
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
$arSelect = Array("ID", "NAME", "CODE");
$arFilter = Array("IBLOCK_ID"=>10, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNext())
{
	$offices[$ob['ID']] = $ob['NAME'];
}
?>
<div class="col col-1">
	<p>Выберите банк (поддерживается произвольный ввод)</p>
	<select id="bank-1-variants-sel" placeholder="Введите название банка...">
		<option value="">Введите название банка...</option>
		<?foreach ($banks as $key => $value):?>
			<option value="<?=$key?>" <?/*if($_REQUEST['bank_name'] == $key) echo ' selected ';*/?>><?=$value?></option>	
		<?endforeach?>
	</select>
</div>

<div class="col col-2">
	<p>Выберите филиал банка</p>
	<select id="bank-2-variants-sel" placeholder="Введите название банка...">
		<option value="">Введите название банка...</option>
		<?foreach ($offices as $key => $value):?>
			<option value="<?=$key?>" <?/*if($_REQUEST['bank_name'] == $key) echo ' selected ';*/?>><?=$value?></option>	
		<?endforeach?>
	</select>
</div>

<script>
	$(function(){
		$("#bank-1-variants-sel").selectize({allowEmptyOption:true});
		$("#bank-2-variants-sel").selectize({allowEmptyOption:true});
	});
</script>
<?
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/selectize.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-ui.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/bootstrap-tagsinput.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/datepicker-ru.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/common.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/cssrefresh.js');
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>