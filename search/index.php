<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("search");

$arFilter = Array("IBLOCK_ID"=>PRODUCTS_INFOBLOCK);
$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetProperties();
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div>
	<input type="text" width="400"/>
	<button id="searchBtn">Искать</button>
	<input type="file" value="Загрузить файл" />
</div>
<div id="result">
	result will be here
</div>

<script type="text/javascript">
$(function(){
	$('#searchBtn').on('click', function(){
		var serials = $(this).parent().find('input[type="text"]').val();
console.log(serials);
		if (serials != undefined) { serials = serials.split(' '); }
console.log(serials);
		$.ajax({
			url: "/bitrix/components/yadadya/search.php",
			data: { ids: serials }
		}).done(function(res){
		});
	});
});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>