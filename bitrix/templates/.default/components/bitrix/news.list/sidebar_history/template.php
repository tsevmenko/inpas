<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
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

	<?foreach($arResult['ITEMS'] as $k => $v):?>
	<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
		<li id="<?=$this->GetEditAreaId($v['ID']);?>">
			<div class="image">
				<?if($v['PREVIEW_PICTURE']['SRC'] == '') $v['PREVIEW_PICTURE']['SRC'] = '/resourses/product-1.jpg';?>
				<a href="<?=$v['DETAIL_PAGE_URL']?>"><img src="<?=$v['PREVIEW_PICTURE']['SRC']?>" alt="<?=$v['NAME']?>"></a>
			</div>
			<div class="text">
				 Товар ID <?=$v['PROPERTIES']['SERIAL_NUMBER']['VALUE']?> был <?=$v['PROPERTIES']['STATUS']['VALUE']?>, остаток гарантийного срока — 
				<? if(strtotime(date("Y-m-d")) > strtotime($v['PROPERTIES']['END_OF_WARRANTY']['VALUE'])): ?>
					истек
				<? else: ?>
					<?$countDays = ceil(s_datediff('d', date('Y-m-d'), $v['PROPERTIES']['END_OF_WARRANTY']['VALUE']));?>
					<?=$countDays;?> <?=declOfNum($countDays, array('день', 'дня', 'дней'));?>
				<? endif; ?>
			</div>
		</li>
	<?endforeach;?>
</ul>