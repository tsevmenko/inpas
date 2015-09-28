<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");?>
<?
	if($_REQUEST['addGroup'] == "Y"){
		$group = new CGroup;
		$arFields = Array(
		  "ACTIVE"       => "Y",
		  "NAME"         => $_REQUEST['name'],
		  "DESCRIPTION"  => $_REQUEST['description']
		);
		$result = $group->Add($arFields);
		if (strlen($group->LAST_ERROR)>0) $result = $group->LAST_ERROR;
	}
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>