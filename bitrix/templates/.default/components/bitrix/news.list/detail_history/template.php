<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>

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

<br /><?=$arResult["NAV_STRING"]?>
