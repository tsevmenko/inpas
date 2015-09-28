<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("report-all-fixes");
CModule::IncludeModule("iblock");

?>

<div class="wrapper2">

	<div class="content2">

		<div class="breadcrumbs">
			<a href="#">Главная</a> <span></span> Все ремонты клиента
		</div>

		<h1>Все ремонты клиента</h1>
		<form id="search">
			<p>Введите клиента</p>
			<div class="row">
				<input type="text" class="input-search-class" id="input-search-1" placeholder="Введите название клиента..." name="CLIENT_BANK_NAME"
				<?if($_REQUEST['CLIENT_BANK_NAME'] != ''):?>
				value="<?=$_REQUEST['CLIENT_BANK_NAME']?>" 
				<?endif;?>>
				<div class="banks-selector">
					<button class="btn-blue">Найти</button>
				</div>
				<div class="clear"></div>
			</div>
		</form>

		<script>
			$(function(){
				$('#search .btn-blue').on('click', function(){
					$("#search").submit();
				});
			});
		</script>

		<div class="clear"></div>
		<div id="resultBlock">
		<?
		if($_REQUEST['CLIENT_BANK_NAME'] != ''){

			/*$arSelect = Array("ID", "NAME");
			$arFilter = Array("IBLOCK_ID"=>10, "ACTIVE"=>"Y", "NAME" => "%СБ РФ%");
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
			$i=0;
			$officeIds = array();
			while($ob = $res->GetNext())
			{
			 	$officeIds[$ob['ID']] = $ob['NAME'];
			}
			d($officeIds);*/

			$connection = odbc_connect(
				"Driver={SQL Server};Server=10.35.1.48;Database=service-center;Client_CSet=UTF-8",
				"yadadya", 
				"yadadya"
			);
			//Царицынское ОСБ № 7978 СБ РФ
			$query = "select distinct equipment_owner from servise_all where equipment_owner LIKE '%".$_REQUEST['CLIENT_BANK_NAME']."%'";
			$query = iconv(mb_detect_encoding($query, mb_detect_order(), true), "windows-1251", $query);
			$result = odbc_exec($connection, $query);
			$officeIds = array();
			while(odbc_fetch_row($result)){

				$odbc_res = odbc_result($result, 1);
				$val = iconv(mb_detect_encoding($odbc_res, mb_detect_order(), true), "UTF-8", $odbc_res);

				$officeIds[] = $val;
			}

			foreach ($officeIds as $key => $value) {
				$key = hash("md5", $key);
				?>
				<h5><span data-elid="<?=$key?>" style="cursor: pointer;" class="allFixesBank"><?=$value?></span><img class="allFixesBankPreloader" src="/resourses/preloader.gif"></h5>
				<div id="bankSection-<?=$key?>">
					
				</div>
				<div class="clear"></div>
				<?
			}
		}
		?>
		</div>
	</div><!-- end content2 -->
</div>
<script type="text/javascript">
	$('h5 span.allFixesBank').on('click', function(){

		var img = $(this).next();

		img.css('display', 'block');

		var bankId = $(this).data("elid");
		var bankName = $(this).text();

		$.ajax({
			url: "/bitrix/components/yadadya/getOneBankFixes.php",
			data: { SELECTED_CLIENT_NAME: bankName }
		}).done(function(data){
			$("#bankSection-" + bankId).html(data);
			img.css('display', 'none');
		});
	});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>