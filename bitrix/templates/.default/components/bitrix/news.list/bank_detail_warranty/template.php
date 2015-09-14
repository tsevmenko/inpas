<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if($_REQUEST['DATE_FROM'] == '') $_REQUEST['DATE_FROM'] = date("d.m.Y");
if($_REQUEST['DATE_TO'] == '') $_REQUEST['DATE_TO'] = date("d.m.Y");
?>

<div class="bottom-picker">

	<h2>Кол-во оборудования, снятого с гарантии</h2>

	<div class="period-selectors-wrapper" id="bank-periods">
		<div class="col col-1">
			<div class="lbl">Дата отгрузки от</div>
			<div class="date-selector-wrapper"><input type="text" data-link="/bitrix/components/yadadya/bankdetailwarrantyblock.php" id="date-pick-1" name="DATE_FROM" value="<?=$_REQUEST['DATE_FROM']?>"><button></button></div>
		</div>
		<div class="col col-2">
			<div class="lbl">Дата отгрузки до</div>
			<div class="date-selector-wrapper"><input type="text" data-link="/bitrix/components/yadadya/bankdetailwarrantyblock.php" id="date-pick-2" name="DATE_TO" value="<?=$_REQUEST['DATE_TO']?>"><button></button></div>
		</div>
		<div class="col col-3">
			<button class="date-clear"></button>
		</div>
	</div>

	<div class="clear"></div>

	<div class="alert green width800">
		<?=$arResult['NAV_RESULT']->NavRecordCount?> аппаратов снято с гарантии до истечения гарантийного срока (в рамках заданных параметров времени)
		<div class="alert-close">×</div>
	</div>

	<ul class="last-list" style="padding-left: 0;">

		<?foreach($arResult['ITEMS'] as $k => $v):?>
		<?
			$this->AddEditAction($v['ID'], $v['EDIT_LINK'], CIBlock::GetArrayByID($v["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($v['ID'], $v['DELETE_LINK'], CIBlock::GetArrayByID($v["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
			<li id="<?=$this->GetEditAreaId($v['ID']);?>">
				<div class="image">
					<?if($v['PREVIEW_PICTURE']['SRC'] == '') $v['PREVIEW_PICTURE']['SRC'] = '/resourses/product-1.jpg';?>
					<a href="<?=$v['DETAIL_PAGE_URL']?>"><img src="<?=$v['PREVIEW_PICTURE']['SRC']?>" alt="<?=$v['NAME']?>"></a>
				</div>
				<div class="text">
					 Товар ID <?=$v['PROPERTIES']['SERIAL_NUMBER']['VALUE']?> был <?=$v['PROPERTIES']['STATUS']['VALUE']?>, остаток гарантийного срока — 
					<? if(strtotime(date("Y-m-d")) > strtotime($v['PROPERTIES']['END_OF_WARRANTY']['VALUE'])): ?>
						истек <?=$v['PROPERTIES']['END_OF_WARRANTY']['VALUE']?>
					<? else: ?>
						<?$countDays = ceil(s_datediff('d', date('Y-m-d'), $v['PROPERTIES']['END_OF_WARRANTY']['VALUE']));?>
						<?=$countDays;?> <?=declOfNum($countDays, array('день', 'дня', 'дней'));?>
					<? endif; ?>
				</div>
			</li>
		<?endforeach;?>
	
	</ul>

</div>

<?=$arResult["NAV_STRING"]?>
