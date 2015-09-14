<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

	$APPLICATION->IncludeComponent(
		"yadadya:last.activity",
		"",
		Array());?>

<script src="<?=SITE_TEMPLATE_PATH?>/js/datepicker-ru.js"/>
<script src="<?=SITE_TEMPLATE_PATH?>/js/common.js"/>

<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php"); ?>