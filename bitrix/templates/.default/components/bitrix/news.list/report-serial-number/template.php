<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<?// declare variable in session for probably xls order query 

	$_SESSION['report-serial-number'] = array();
	
	// end SESSION declare
?>	
<a class="btn-white right" href="/phpexcel/ShippingEquipmentReport.php">Скачать отчет</a>

	<div class="clear"></div>
	<?if(count($arResult['ITEMS']) == 0):?>
		<div class="no-result">
			<div class="no-result-title">Аппаратов не найдено</div>
			<div class="no-result-image"><img src="<?=SITE_TEMPLATE_PATH?>/images/empty.png" alt=""></div>
			<p>К сожалению по вашему запросу ни одного аппарата не найдено. Попробуйте изменить параметры поиска</p>
		</div>
	<?else:?>
	<table class="all-banks-table5 sort">
		<tr>
			<td>№</td>
			<td>Наименование</td>
			<td>Серийный<br />номер</td>
			<td>Дата отгрузки</td>
			<td>Окончание<br />гарантии</td>
			<td>Номер счета</td>
			<td>Статус по сервису</td>
		</tr>
		<? $i = 1; foreach($arResult["ITEMS"] as $arItem):?>
		<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			$_SESSION['report-serial-number'][] = $arItem['ID'];
		?>
			<tr id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<td><?=$i++;?></td>
				<td><?=$arItem['NAME']?></td>
				<td><?=$arItem['PROPERTIES']['SERIAL_NUMBER']['VALUE']?></td>
				<td><span class="date"><?=$arItem['PROPERTIES']['SHIPPING_DATE']['VALUE']?></span></td>
				<td><span class="date"><?=$arItem['PROPERTIES']['END_OF_WARRANTY']['VALUE']?></span></td>
				<td><?=$arItem['PROPERTIES']['BILL_NUMBER']['VALUE']?></td>
				<td><?=$arItem['PROPERTIES']['STATUS']['VALUE']?></td>
			</tr>
		<?endforeach;?>
	</table>
	<?endif;?>
	<div class="clear"></div>  


	<? if(count($arResult['ITEMS']) > 0):?>
		<?=$arResult["NAV_STRING"]?>
	<? endif; ?>