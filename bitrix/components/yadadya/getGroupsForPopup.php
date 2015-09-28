<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/jquery-ui.css');
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/style.css');
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/tabs.css');
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/selectize.css');

	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/bootstrap-tagsinput.css');

	CModule::IncludeModule("iblock");

	$offices = array();

	$arSelect = Array("ID", "NAME", "CODE");
	$arFilter = Array("IBLOCK_ID"=>10, "ACTIVE"=>"Y");
	$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);?>

	<div class="row">
		<div class="label">Группы</div>
		<div class="banks-selector">
			<div class="no-aval">
				<select name="group" id="bank-2-variants-sel" placeholder="Введите филиал банка...">
					<option value="">Введите филиал банка...</option>
				<? while($ob = $res->GetNext()) {?>
					<option value="<?=$ob['ID']?>"><?=$ob['NAME']?></option>
				<?}?>
				</select>
			</div>
		</div>
	</div>

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