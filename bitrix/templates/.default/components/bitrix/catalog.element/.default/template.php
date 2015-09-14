<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<br/>
	<h1>Товар серийный номер <?=$arResult['PROPERTIES']['SERIAL_NUMBER']['VALUE']?></h1>

    <h3>Модель <?=$arResult['PROPERTIES']['MODEL']['VALUE']?></h3>

	<? $link = "/resourses/productReport.php?type=getReport&productReport=Y"; ?>

	<a class="btn-white right" href="/resourses/productReport.php?type=getReport&productReport=Y" style="margin-top: 10px;">Скачать отчет по данному товару</a>

    <div class="clear"></div>

	<table class="all-banks-table1">
		<tr>
			<td>Владелец</td>
			<td>Дата отгрузки</td>
			<td>Окончание гарантии</td>
			<td>Номер счета</td>
			<td>Номер накладной</td>
			<td>Статус</td>
		</tr>
		<tr>
			<td><a href="#"><?=$arResult['PROPERTIES']['OWNER']['VALUE']?></a></td>
			<td><?=$arResult['PROPERTIES']['SHIPPING_DATE']['VALUE']?></td>
			<td><?=$arResult['PROPERTIES']['END_OF_WARRANTY']['VALUE']?></td>
			<td><?=$arResult['PROPERTIES']['BILL_NUMBER']['VALUE']?></td>
			<td><?=$arResult['PROPERTIES']['DELIVERY_NOTE']['VALUE']?></td>
			<td><?=$arResult['PROPERTIES']['STATUS']['VALUE']?></td>
		</tr>
	</table>

<div class="clear"></div>

<h4>История</h4>

<table class="all-banks-table2">	
	<tr>
		<td>Дата</td>
		<td>Действие</td>
	</tr>

	<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
		<tr id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<td><?=$arItem['ACTIVE_FROM']?></td>
			<td><span><?=$arItem['NAME']?></span>
				<? if(count($arItem['COMMENTS']) > 0):?>
					<div class="splCont">
						<span class="s1"><?=$arProperty["NAME"]?>,</span> <span class="s2"><?=$arProperty["DATE"]?></span>
						<div class="clear"></div>
						<div class="quote"><?=$arProperty['TEXT']?></div>
					</div>
				<? endif; ?>
			</td>
		</tr>

	<?endforeach;?>

</table>



<?
	//d($arResult);
	return $arResult['PEROPERTIES']['HISTORY']['VALUE'];
?>
