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

	<?foreach($arResult['PROPERTIES']['HISTORY']["VALUE"] as $arItem):?>
		<tr>
			<td><?=date("d-m-Y", strtotime($arResult['PROPERTIES']['HISTORY']['TIMESTAMP_X']))?></td>
			<td><span><?=$arItem?></span></td>
		</tr>
	<?endforeach;?>

</table>