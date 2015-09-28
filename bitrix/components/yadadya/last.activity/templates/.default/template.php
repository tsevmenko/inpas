<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
	CModule::IncludeModule("iblock");
	$ids = Array();
	$result = Array();
	$arSelect = Array();
	if(($_REQUEST['DATE_FROM'] == '' && $_REQUEST['DATE_TO'] == '') || ($_REQUEST['DATE_FROM'] == 'none' && $_REQUEST['DATE_TO'] == 'none')){
		$_REQUEST['DATE_FROM'] = date("d.m.Y");
		$_REQUEST['DATE_TO'] = date("d.m.Y");
	}

	$arFilter = Array("IBLOCK_ID"=>7,
			'>=DATE_CREATE' => $_REQUEST['DATE_FROM'],
  			'<=DATE_CREATE' => $_REQUEST['DATE_TO'] . ' 23:59:59');

	$result = array();
	$res = CIBlockElement::GetList(Array("DATE_CREATE"), $arFilter, false, false, $arSelect);
	while($ob = $res->GetNext())
	{
		$obj = array();
		$obj['ID'] = $ob['NAME'];
		switch($ob['PREVIEW_TEXT']){
			case "UPD":
				$obj['TEXT'] = " был обновлен, остаток гарантийного срока - ".$ob['DETAIL_TEXT'];
			break;
			case "ADD":
				$obj['TEXT'] = " был добавлен, остаток гарантийного срока - ".$ob['DETAIL_TEXT'];
			break;
		}

		$result[] = $obj;
	}
	/*$arSelect = Array();
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
	}*/
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
				<?$date = ($_REQUEST['DATE_FROM'] == '') ? date("d.m.Y") : $_REQUEST['DATE_FROM'];?>
				<input type="text" id="date-pick-1" value="<?=$date?>"><button></button>
			</div>
		</div>
		<div class="col col-2">
			<div class="date-selector-wrapper">
				<?$date = ($_REQUEST['DATE_TO'] == '') ? date("d.m.Y") : $_REQUEST['DATE_TO'];?>
				<input type="text" id="date-pick-2" value="<?=$date?>"><button></button>
			</div>
		</div>
		<div class="col col-3">
			<button class="date-clear"></button>
		</div>
		<div class="clear"></div>
	</div>
	<ul class="last-list" style="padding-left: 0;">
		<?if(count($result) == 0):?>
			<div class="no-result">
				<div class="no-result-title">
					 Аппаратов не найдено
				</div>
				<div class="no-result-image">
					<img src="<?=SITE_TEMPLATE_PATH?>/images/app.png" alt="">
				</div>
				<p>
					 К сожалению по вашему запросу аппаратов не найдено. Попробуйте изменить параметры поиска
				</p>
			</div>
		<?endif;?>
		<?foreach($result as $k => $v):?>
			<li>
				<div class="image">
					<?if($v['PIC'] == '') $v['PIC'] = '/resourses/product-1.jpg';?>
					<a href="/device/ELEMENT_ID=<?=$v['NAME']?>"><img src="<?=$v['PIC']?>" alt="<?=$v['TEXT']?>"></a>
				</div>
				<div class="text">
					 Товар ID <?=$v['ID']?> <?=$v['TEXT']?>
				</div>
			</li>
		<?endforeach;?>
	</ul>
