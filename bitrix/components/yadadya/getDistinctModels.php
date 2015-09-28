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
$arSelect = Array("ID", "NAME", "CODE", "PROPERTY_ORA_ID", "PROPERTY_ORA_PRFX");
$arFilter = Array("IBLOCK_ID"=>10, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNext())
{
	$offices[$ob['PROPERTY_ORA_ID_VALUE']] = array($ob['NAME'], $ob['PROPERTY_ORA_PRFX_VALUE']);
}
// get all models
$arSelect = Array("ID", "NAME", "CODE");
$arFilter = Array("IBLOCK_ID"=>6, "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, Array("NAME"), false, $arSelect);
while($ob = $res->GetNext())
{
	$models[$ob['NAME']] = $ob['NAME'];
}
?>
<div class="banks-selector report">
	<div class="col mb15">
		<p>Выберите банк (поддерживается произвольный ввод)</p>
		<select name="bank_name" id="bank-1-variants-selrb" placeholder="Введите название банка...">
			<option value="">Введите название банка...</option>
			<?foreach ($banks as $key => $value):?>
				<option data-ii="<?=$key?>" value="<?=$key?>" <?/*if($_REQUEST['bank_name'] == $key) echo ' selected ';*/?>><?=$value?></option>	
			<?endforeach?>
		</select>
	</div>

	<div class="col">
		<p>Выберите филиал</p>
		<select name="office_name" id="bank-2-variants-selrb" placeholder="Введите филиал банка...">
			<option value="">Введите филиал банка...</option>
			<?foreach ($offices as $key => $value):?>
				<option value="<?=$key?>" <?/*if($_REQUEST['office_name'] == $key) echo ' selected ';*/?>><?=$value[0]?></option>	
			<?endforeach?>			
		</select>
	</div>

	<div class="col no-padding" id="models">
		<p>Выберите модель</p>
		<select name="device_model" id="bank-3-variants-selrb" placeholder="Введите модель аппарата...">
			<option value="">Введите модель аппарата...</option>
			<?foreach ($models as $key => $value):?>
				<option value="<?=$key?>" <?/*if($_REQUEST['device_model'] == $key) echo ' selected ';*/?>><?=$value?></option>	
			<?endforeach?>
		</select>
	</div>
	
	<div class="clear"></div>
	
</div>

<div class="report-2-col">

	<div class="col-1" id="taginput">
		<p>Введите через запятую серийные номера</p>
		<input type="text" class="serial"   data-role="tagsinput" value="<?if($_REQUEST['SERIAL_NUMBER'] != '') echo $_REQUEST['SERIAL_NUMBER'];?>" placeholder="8685. 5512">
	</div>

	<div class="col-2">

		<div class="period-selectors-wrapper" id="bank-periods">
			<div class="col col-1">
				<div class="lbl">Период</div>
				<div class="date-selector-wrapper"><input type="text" name="DATE_FROM" id="date-pick-1" value="<?if($_REQUEST['date_from'] != '') echo $_REQUEST['date_from']?>"><button></button></div>
			</div>
			<div class="col col-2">
				<div class="lbl">&nbsp;</div>
				<div class="date-selector-wrapper"><input type="text" name="DATE_TO" id="date-pick-2" value="<?if($_REQUEST['date_to'] != '') echo $_REQUEST['date_to']?>"><button></button></div>
			</div>
			<div class="col col-3">
				<button class="date-clear"></button>
			</div>
		</div>

		<div class="col col-4">
			<button class="btn-blue">Сгенерировать отчёт</button>
		</div>

	</div>

</div>
<script>
	$(function(){
		$("#bank-1-variants-selrb").selectize({allowEmptyOption:true,
		    delimiter: ';',
		    labelField: "label",
		    valueField: "value",
		    searchField: "label",
		    render: {
		        option: function(data, escape) {
				    return '<div data-asd="asd" data-value="'+data.value+'" >'+data.label+'</div>';
				}
		}});
		$("#bank-2-variants-sel").selectize({allowEmptyOption:true});
		$("#bank-3-variants-sel").selectize({allowEmptyOption:true});
		$("#bank-4-variants-sel").selectize({allowEmptyOption:true});

		var $sel_bank, $sel_phil, $sel_model;

		$sel_bank = $("#bank-1-variants-selrb").selectize({
			allowEmptyOption:true,
			onChange: function(value) {
				var phil = $sel_phil[0].selectize
				var model = $sel_model[0].selectize
				if (value.length > 0) {
					phil.enable()
				} else {
					phil.disable()
					phil.setValue("")
					model.disable()
					model.setValue("")
				}
			}
		});
		$sel_phil = $("#bank-2-variants-selrb").selectize({
			allowEmptyOption:true,
			onChange: function(value) {
				var model = $sel_model[0].selectize
				if (value.length > 0) {
					model.enable()
				} else {
					model.disable()
					model.setValue("")
				}
			}
		});
		$sel_model = $("#bank-3-variants-selrb").selectize({allowEmptyOption:true});
		if ($sel_phil[0] !== undefined) {
			$sel_phil[0].selectize.disable()
		}
		if ($sel_model[0] !== undefined) {
			$sel_model[0].selectize.disable()
		}

		$( "#date-pick-1" ).datepicker({
			showOtherMonths: true,
			onSelect: function(date){
				
			},
			beforeShow:function(textbox, instance){
		    	var element = $('#ui-datepicker-div').detach();
		    	$('#bank-periods').append(element);
			}
			
		});

		$( "#date-pick-2" ).datepicker({
			showOtherMonths: true,
			onSelect: function(date){
				
			},
			beforeShow:function(textbox, instance){
		    	var element = $('#ui-datepicker-div').detach();
		    	$('#bank-periods').append(element);
			}
		});

		$("#bank-periods .date-clear").on('click', function(){
			$("option:selected").removeAttr("selected");
			$('.date-selector-wrapper input').val('');
			return false;
		});

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