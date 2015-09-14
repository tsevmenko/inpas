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
			<th>Отделение банка</th>
			<th>Кол-во <br>аппаратов</th>
			<th>Последняя активность</th>
			<th>Дата <br>активности</th>
		</tr>
		<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
			<tr id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<td><a href="#"><?=$arItem['NAME']?></a></td>
				<td><?=count($arItem['PROPERTIES']['DEVICES']['VALUE'])?></td>
				<td><?=$arItem['PROPERTIES']['LAST_ACTIVITY']['VALUE']?></td>
				<td><span class="date"><?=$arItem['PROPERTIES']['LAST_ACTIVITY_DATE']['VALUE']?></span></td>
			</tr>
		<?endforeach;?>

	</table>
	<? if(count($arResult['ITEMS']) > 0):?>
		<?=$arResult["NAV_STRING"]?>
	<? endif; ?>