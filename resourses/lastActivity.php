<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>

	<?
	CModule::IncludeModule("iblock");
	$ids = Array();
	$result = Array();
	$arSelect = Array();
	if($_REQUEST['DATE_FROM'] == '' && $_REQUEST['DATE_TO'] == '')
		$arFilter = Array("IBLOCK_ID"=>7);
	else
		$arFilter = Array("IBLOCK_ID"=>7, 
				'>=DATE_CREATE' => $_REQUEST['DATE_FROM'],
      			'<=DATE_CREATE' => $_REQUEST['DATE_TO'] . ' 23:59:59');

	$res = CIBlockElement::GetList(Array("DATE_CREATE"), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();
		$ids[] = $arFields['ID'];
		$result[$arFields['ID']] = Array("TEXT" => $arFields["NAME"], "PLACE" => $arProps['PLACE']['VALUE'], "DATE_CREATE" => $arFields['DATE_CREATE']);
	}
	$arSelect = Array();
	$arFilter = Array("IBLOCK_ID"=>6, "PROPERTY_HISTORY" => $ids);
	$res = CIBlockElement::GetList(Array("DATE_CREATE"), $arFilter, false, false, $arSelect);

	while($ob = $res->GetNextElement())
	{
		$arFields = $ob->GetFields();
		$arProps = $ob->GetProperties();

		foreach($arProps['HISTORY']['VALUE'] as $k => $v){
			if($result[$v] != ''){
				$result[$v]['SERIAL'] = $arProps['SERIAL_NUMBER']['VALUE'];
				if(strtotime(date("Y-m-d")) > strtotime($arProps['END_OF_WARRANTY']['VALUE']))
					$result[$v]['WARRANTY'] = " истек ";
				else
				{
					$countDays = ceil(s_datediff('d', date('Y-m-d'), $arProps['END_OF_WARRANTY']['VALUE']));
					$result[$v]['WARRANTY'] = $countDays.declOfNum($countDays, array('день', 'дня', 'дней'));
				}
				$result[$v]['PIC'] = CFile::GetPath($arFields['PREVIEW_PICTURE']);
			}
		}
	}
	?>
	<div class="block-title">
		 Последние изменения по сервису
	</div>
	<div class="period-selectors-wrapper" id="bank-periods">
		<div class="lbl">
			 Период
		</div>
		<div class="col col-1">
			<div class="date-selector-wrapper">
				<input type="text" id="date-pick-1" value="28.06.2015"><button></button>
			</div>
		</div>
		<div class="col col-2">
			<div class="date-selector-wrapper">
				<input type="text" id="date-pick-2" value="28.06.2015"><button></button>
			</div>
		</div>
		<div class="col col-3">
			<button class="date-clear"></button>
		</div>
		<div class="clear"></div>
	</div>
	<ul class="last-list" style="padding-left: 0;">

		<?foreach($result as $k => $v):?>
			<li>
				<div class="image">
					<?if($v['PIC'] == '') $v['PIC'] = '/resourses/product-1.jpg';?>
					<a href="#"><img src="<?=$v['PIC']?>" alt="<?=$v['TEXT']?>"></a>
				</div>
				<div class="text">
					 <?=$v['DATE_CREATE']?>Товар ID <?=$v['SERIAL']?> <?=$v['TEXT']?>, остаток гарантийного срока — <?=$v['WARRANTY']?>
				</div>
			</li>
		<?endforeach;?>
	</ul>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>