<?
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "elementHandlerUpdate");
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "elementHandlerAdd");

define("PRODUCTS_INFOBLOCK", 6);
define("REGION_INFOBLOCK", 9);
define("OFFICE_INFOBLOCK", 10);
define("BANK_INFOBLOCK", 11);

function declOfNum($number, $titles)
{
    $cases = array (2, 0, 1, 1, 1, 2);
    return $number." ".$titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $generateRandomStringtring = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function s_datediff( $str_interval, $dt_menor, $dt_maior, $relative=false){

   if( is_string( $dt_menor)) $dt_menor = date_create( $dt_menor);
   if( is_string( $dt_maior)) $dt_maior = date_create( $dt_maior);

   $diff = date_diff( $dt_menor, $dt_maior, ! $relative);

   switch( $str_interval){
	   case "y": 
		   $total = $diff->y + $diff->m / 12 + $diff->d / 365.25; break;
	   case "m":
		   $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
		   break;
	   case "d":
		   $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
		   break;
	   case "h": 
		   $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
		   break;
	   case "i": 
		   $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
		   break;
	   case "s": 
		   $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
		   break;
	  }
	if( $diff->invert)
		return -1 * $total;
  	else 
    	return $total;
}

function d($ar)
{
    global $USER;
    if($USER->IsAdmin())
    {
        echo '<pre>'; print_r($ar);echo '</pre>';
    }
}

function elementHandlerUpdate($arFields)
{
    if($arFields['IBLOCK_ID'] == 6){

        $el = new CIBlockElement;

        reset($arFields['PROPERTY_VALUES'][19]);
        $first_key = key($arFields['PROPERTY_VALUES'][19]);
        $endOfWarranty = $arFields['PROPERTY_VALUES'][19][$first_key]['VALUE'];


        if(strtotime(date("Y-m-d")) > strtotime($endOfWarranty))
            $endOfWarranty = " истек ";
        else
        {
            $countDays = ceil(s_datediff('d', date('Y-m-d'), $endOfWarranty));
            $endOfWarranty = declOfNum($countDays, array('день', 'дня', 'дней'));
        }

        $arLoadProductArray = Array(
          "IBLOCK_ID"      => 7,
          "NAME"           => $arFields['NAME'],
          "ACTIVE"         => "Y",
          "PREVIEW_TEXT"   => "UPD",
          "DETAIL_TEXT"    => $endOfWarranty,
        );

        $PRODUCT_ID = $el->Add($arLoadProductArray);
    }
    
}

function elementHandlerAdd($arFields)
{
    if($arFields['IBLOCK_ID'] == 6){

        $el = new CIBlockElement;

        reset($arFields['PROPERTY_VALUES'][19]);
        $first_key = key($arFields['PROPERTY_VALUES'][19]);
        $endOfWarranty = $arFields['PROPERTY_VALUES'][19][$first_key]['VALUE'];


        if(strtotime(date("Y-m-d")) > strtotime($endOfWarranty))
            $endOfWarranty = " истек ";
        else
        {
            $countDays = ceil(s_datediff('d', date('Y-m-d'), $endOfWarranty));
            $endOfWarranty = declOfNum($countDays, array('день', 'дня', 'дней'));
        }

        $arLoadProductArray = Array(
          "IBLOCK_ID"      => 7,
          "NAME"           => $arFields['ID'],
          "ACTIVE"         => "Y",
          "PREVIEW_TEXT"   => "UPD",
          "DETAIL_TEXT"    => $endOfWarranty,
        );

        $PRODUCT_ID = $el->Add($arLoadProductArray);
    }
   
	// add | save history comment
	if($arFields['IBLOCK_ID'] == 8){
		// add fio as comment name
		global $USER;
		$arFields['NAME'] = $USER->GetFullName();
		$arFields['ACTIVE_FROM'] = ConvertTimeStamp(time(), "FULL");
	}

}

function ConnectToOracleDB(){

    $dbusername = "wrhs";
    $dbpass = "warehouse";
    $dbhost = "(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=10.129.6.71)(PORT=1521)))(CONNECT_DATA=(SERVICE_NAME=ora5.itgroup.local)))";

    $conn = oci_pconnect($dbusername, $dbpass, "//10.129.6.71:1521/ora5.itgroup.local", "AL32UTF8"); //"ORA5");//, $dbhost);

    if($conn){
		//echo 'Соединение с базой Oracle установлено.<br/>';
   	}
    else{
		//d(oci_error());
		//die ('Oracle connection error.');
    }

    return $conn;
}

function ConnectToMSSQL(){
    $connection = odbc_connect("Driver={SQL Server};Server=10.35.1.48;Database=service-center;", "yadadya", "yadadya");    
    return $connection;
}

function GetMSSQLData($conn, $query){

    $result = odbc_exec($conn, $query);
    $resAr = array();

    while(odbc_fetch_row($result)){

        $obj = array();
        for($i=1; $i<=odbc_num_fields($result); $i++){

            $odbc_res = odbc_result($result, $i);

            $val = iconv(mb_detect_encoding($odbc_res, mb_detect_order(), true), "UTF-8", $odbc_res);
            
            switch ($i) {
                case 1: break;
                case 2: $obj['NAME'] = $val; break;
                case 3: $obj['FAULT'] = $val; break;
                case 4: $obj['OWNER'] = $val; break;
                case 5: $obj['SERIAL_NUM'] = str_replace('-', '', $val); break;
                case 6: $obj['SUBMIT_DATE'] = $val; break;
                case 7: $obj['MAIN_STATUS'] = $val; break;
                case 8: $obj['ACTION_TIMESTAMP'] = $val; break;
                default: 
                    if($val != '')
                        $obj['SERVICE_OPERATIONS'][] = $val;
                break;
            }

        }
        if($resAr[$obj['SERIAL_NUM']] != ''){
            foreach ($obj['SERVICE_OPERATIONS'] as $k => $v) {
                if($vv != '')
                    $resAr[$obj['SERIAL_NUM']]['SERVICE_OPERATIONS'][] = $vv;
            }
        }
        else
            $resAr[$obj['SERIAL_NUM']] = $obj;
    }
    
    odbc_close($conn);

    return $resAr;
}

function oracleQueryExecute($conn, $query){

	$stid = oci_parse($conn, $query);
	if (!$stid) {
	    $e = oci_error($conn);
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	$r = oci_execute($stid);
	if (!$r) {
	    $e = oci_error($stid);
	    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	return $stid;
}

?>