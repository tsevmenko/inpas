<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>


	<? if(count($arResult['ITEMS']) == 0):?>
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
	<? return; ?>
	<? endif; ?>
	<div class="block-title">Все отделения банков</div>

	<table class="all-banks-table">
		<tr>
			<th>Порядковый <br>номер</th>
			<th>Серийный <br>номер</th>
			<th>Наименование <br>оборудования</th>
			<th>Номер партии <br>оборудования</th>
			<th>Статус</th>
			<th>Дата отгрузки</th>
			<th>Срок истечения <br>гарантии</th>
			<th>Наименование <br>клиента</th>
			<th>Номер счета</th>
			<th>Номер накладной</th>
		</tr>
		<? $i = 1; foreach($arResult["ITEMS"] as $arItem):?>
		<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
			<tr id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<td><?=$i++?></td>
				<td><a href="#"><?=$arItem['PROPERTIES']['SERIAL_NUMBER']['VALUE']?></a></td>
				<td><?=$arItem['NAME']?></td>
				<td><?=$arItem['PROPERTIES']['LOT_NUMBER']['VALUE']?></td>
				<td><?=$arItem['PROPERTIES']['STATUS']['VALUE']?></td>
				<td><span class="date"><?=$arItem['PROPERTIES']['SHIPPING_DATE']['VALUE']?></span></td>
				<? if(strtotime(date("Y-m-d")) > strtotime($arItem['PROPERTIES']['END_OF_WARRANTY']['VALUE'])): ?>
					<td>Истек</td>
				<? else: ?>
					<td><?=ceil(s_datediff('d', date('Y-m-d'), $arItem['PROPERTIES']['END_OF_WARRANTY']['VALUE']));?></td>
				<? endif; ?>
				<td><?=$arItem['PROPERTIES']['OWNER']['VALUE']?></td>
				<td><?=$arItem['PROPERTIES']['BILL_NUMBER']['VALUE']?></td>
				<td><?=$arItem['PROPERTIES']['DELIVERY_NOTE']['VALUE']?></td>
			</tr>
		<?endforeach;?>
	</table>

	<? if(count($arResult['ITEMS']) > 0):?>
		<?=$arResult["NAV_STRING"]?>
	<? endif; ?>