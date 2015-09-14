<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

	<? if($arProps['BANK_NAME'] != ''): ?>
		<h2>Клиент: <?=$arProps['BANK_NAME']?></h2>
	<? else: ?>
<h2>Результаты фильтрации:</h2>
	<? endif; ?>
<h5>Период: <span>от <?=ConvertDateTime($_REQUEST['DATE_FROM'], "d/m/Y")?> до <?=ConvertDateTime($_REQUEST['DATE_TO'], "d/m/Y")?></span></h5>

<a class="btn" href="/phpexcel/ShippingEquipmentReport.php">Скачать отчет</a>

	<div class="clear"></div>

	<table class="all-banks-table3">
		<tr>
			<td>№</td>
			<td>Наименование</td>
			<td>Серийный<br />номер</td>
			<td>Дата отгрузки</td>
			<td>Окончание<br />гарантии</td>
			<td>Статус по сервису</td>
		</tr>
		<? $i = 1; foreach($arResult["ITEMS"] as $arItem):?>
		<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
			<tr id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<td><?=$i++;?></td>
				<td><?=$arItem['NAME']?></td>
				<td><?=$arItem['PROPERTIES']['SERIAL_NUMBER']['VALUE']?></td>
				<td><span class="date"><?=$arItem['PROPERTIES']['SHIPPING_DATE']['VALUE']?></span></td>
				<td><span class="date"><?=$arItem['PROPERTIES']['END_OF_WARRANTY']['VALUE']?></span></td>
				<td><?=$arItem['PROPERTIES']['STATUS']['VALUE']?></td>
			</tr>
		<?endforeach;?>
	</table>

	<div class="clear"></div>  


	<? if(count($arResult['ITEMS']) > 0):?>
		<?=$arResult["NAV_STRING"]?>
	<? endif; ?>