<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?/*<h5 class="report-all-fixes"><?=$arParams['BANK_NAME']?></h5>*/?>
		
	<a class="btn-white right" href="#">Скачать отчет</a>
	
	<?// declare variable in session for probably xls order query 

	$_SESSION['report-all-fixes'] = array();
	
	// end SESSION declare
	?>

	<div class="clear"></div>
	<?if(count($arResult['ITEMS']) == 0):?>
		<div class="no-result">
			<div class="no-result-title">
				 Аппаратов не найдено
			</div>
			<div class="no-result-image">
				<img src="/bitrix/templates/INPAS/images/app.png" alt="">
			</div>
			<p>
				 К сожалению по вашему запросу ремонтов не найдено. Попробуйте изменить параметры запроса
			</p>
		</div>
	<?else:?>
	<table class="all-banks-table3 sort">
		<thead>
			<tr>
				<td>№</td>
				<td>Наименование</td>
				<td>Серийный<br />номер</td>
				<td>Дата отгрузки</td>
				<td>Окончание<br />гарантии</td>
				<td>Статус по сервису</td>
			</tr>
		</thead>
		<tbody>
			<?$i = 1;?>
			<?foreach ($arResult['ITEMS'] as $k => $v):?>
				<?
					$this->AddEditAction($v['ID'], $v['EDIT_LINK'], CIBlock::GetArrayByID($v["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($v['ID'], $v['DELETE_LINK'], CIBlock::GetArrayByID($v["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					$_SESSION['report-all-fixes'][] = $arItem['ID'];
				?>
				<tr id="<?=$this->GetEditAreaId($v['ID']);?>">
					<td><?=$i++;?></td>
					<td><?=$v['NAME']?></td>
					<td><?=$v['PROPERTIES']['SERIAL_NUMBER']['VALUE']?></td>
					<td><?=$v['PROPERTIES']['SHIPPING_DATE']['VALUE']?></td>
					<td><?=$v['PROPERTIES']['END_OF_WARRANTY']['VALUE']?></td>
					<td><?=$v['PROPERTIES']['STATUS']['VALUE']?></td>
				</tr>	
			<? endforeach ?>
			
		</tbody>
	</table>
	<?endif;?>
	<div class="clear"></div>
	<? if($arResult['NAV_RESULT']->nEndPage != 1):?>
		<?=$arResult["NAV_STRING"]?>
	<? endif; ?>