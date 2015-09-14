<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
define(PAGE_SIZE, 1000);
global $USER;
set_time_limit (100000000); 
CModule::IncludeModule("iblock");

function GetProductsCount($conn){
    $query = 'SELECT COUNT(*) as "COUNT"
                     FROM EQUIPMENT_HB eq, TERM_SHIPP ship 
                     WHERE eq.PARTNUM = ship.TYPE_EQUIP
                     ORDER BY ship.SERIAL_NUM';
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
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) { oci_free_statement($stid); return $row['COUNT']; }
}
function getProductsFrom($userId, $conn, $startSerial, $DB){
    
    $querystart = microtime(true);

    if($startSerial){
        $query = 'SELECT ship.SERIAL_NUM, 
                         eq.NAME, 
                         ship.CUSTOMER_ID, 
                         TO_CHAR( ship.DATA_REG, \'dd.mm.yyyy\' ) as DATA_REG, 
                         TO_CHAR( ship.WARRANTY, \'dd.mm.yyyy\' ) as WARRANTY, 
                         (SELECT NAME FROM STATUS_HB WHERE ID = ship.STATUS_ID) as STATUS, 
                         ship.INVOICE, 
                         ship.WAYBILL, 
                         eq.PARTNUM, 
                         eq.NAME 
                         FROM EQUIPMENT_HB eq, TERM_SHIPP ship 
                         WHERE eq.PARTNUM = ship.TYPE_EQUIP AND ship.SERIAL_NUM > \''.$startSerial.'\' AND ROWNUM < '.(PAGE_SIZE + 1).'
                         ORDER BY ship.SERIAL_NUM';
    }
    else{
        $query = 'SELECT ship.SERIAL_NUM, 
                         eq.NAME, 
                         ship.CUSTOMER_ID, 
                         TO_CHAR( ship.DATA_REG, \'dd.mm.yyyy\' ) as DATA_REG, 
                         TO_CHAR( ship.WARRANTY, \'dd.mm.yyyy\' ) as WARRANTY, 
                         (SELECT NAME FROM STATUS_HB WHERE ID = ship.STATUS_ID) as STATUS, 
                         ship.INVOICE, 
                         ship.WAYBILL, 
                         eq.PARTNUM, 
                         eq.NAME 
                         FROM EQUIPMENT_HB eq, TERM_SHIPP ship 
                         WHERE eq.PARTNUM = ship.TYPE_EQUIP AND ROWNUM < '.(PAGE_SIZE + 1).'
                         ORDER BY ship.SERIAL_NUM';
    }
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
    $i = 0;
    $resAr = array();
    $mssqlsn = ''; // mssql serial numbers

    $time = microtime(true) - $querystart;
    printf('Выполнили запрос Oracle за %.2F сек.<br/>', $time);

    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        
        $obj = array();
        $obj[15] = $row['SERIAL_NUM'];
        $obj[16] = $row['NAME'];
        $obj[17] = $row['CUSTOMER_ID'];
        $obj[18] = $row['DATA_REG'];
        $obj[19] = $row['WARRANTY'];
        $obj[20] = $row['STATUS'];
        $obj[21] = $row['INVOICE'];
        $obj[22] = $row['WAYBILL'];
        $obj[34] = $row['PARTNUM'];

        $resAr[$row['SERIAL_NUM']] = $obj;

        $mssqlsn .= '\''.implode('-',str_split($row['SERIAL_NUM'], 3)).'\', ';
        $mssqlsna[] = $row['SERIAL_NUM'];

        if(++$i >= PAGE_SIZE) {

            // get info from mssql 
            $querystart = microtime(true);
            $msdata = GetMSSQLData(ConnectToMSSQL(), 'select * from servise_all where serial_number in ('.substr_replace($mssqlsn ,"",-2).')');
            $time = microtime(true) - $querystart;
            printf('Выполнили запрос MSSQL за %.2F сек.<br/>', $time);
            // merge arrays
            foreach ($msdata as $k => $v) {

                $resAr[$k][20] = $msdata[$k]['MAIN_STATUS'];
                $resAr[$k][23] = $msdata[$k]['SERVICE_OPERATIONS']; 
                $resAr[$k][44] = $msdata[$k]['NAME'];
                $resAr[$k][45] = $msdata[$k]['SUBMIT_DATE'];
                $resAr[$k][46] = $msdata[$k]['ACTION_TIMESTAMP'];
                $resAr[$k][49] = $msdata[$k]['MAIN_STATUS'];
            }
            // save changes
            $savestart = microtime(true);
            SaveOrUpdateElement($resAr, $userId, $mssqlsna, $DB);
            $time = microtime(true) - $savestart;
            printf('Сохранили данные за %.2F сек.<br/>', $time);
            // last moment
            $res = array("serial" => $row['SERIAL_NUM'], "count" => $i); 
            oci_free_statement($stid); 
            return $res;
        }
    }
}
function updateOrInsertProp($val, $propId, $elId, $DB){
    if($propId != 23){
        switch($propId){
            case 18: $val = date("Y-m-d", strtotime($val)); break;
            case 19: $val = date("Y-m-d", strtotime($val)); break;
        }
        $query="SELECT COUNT(*) as 'count' FROM b_iblock_element_property WHERE IBLOCK_PROPERTY_ID = $propId AND IBLOCK_ELEMENT_ID = $elId";
        $result=$DB->Query($query);
        $result = $result->GetNext();
    }
    else{
        $result['count'] = 0;
    }
    if($result['count'] == 0){
        if($propId == 23){
            $result = $DB->Query("delete from b_iblock_element_property where IBLOCK_PROPERTY_ID = $propId AND IBLOCK_ELEMENT_ID = $elId");
            foreach($val as $k => $v){
                $result = $DB->Query("insert into b_iblock_element_property (IBLOCK_PROPERTY_ID, IBLOCK_ELEMENT_ID, VALUE) values ($propId, $elId, '$v')");
            }
        }
        else{
            $result = $DB->Query("insert into b_iblock_element_property (IBLOCK_PROPERTY_ID, IBLOCK_ELEMENT_ID, VALUE) values ($propId, $elId, '$val')");
        }
    }else{
        $result = $DB->Query("update b_iblock_element_property SET VALUE = '$val' WHERE IBLOCK_PROPERTY_ID = $propId AND IBLOCK_ELEMENT_ID = $elId");
    }
    if($result->result != 1){
        echo 'error! val: $val; propId: $propId; elId: $elId<br/>';
    }
}
function SaveOrUpdateElement($res, $userId, $serials, $DB){

    $arFilter = Array("IBLOCK_ID" => 6, "PROPERTY_SERIAL_NUMBER" => $serials);
    $r = CIBlockElement::GetList(Array(), $arFilter, false, false, Array("ID", "IBLOCK_ID", "PROPERTY_SERIAL_NUMBER"));
    
    $serials = array();

    while($ob = $r->GetNext()){
        $serials[$ob['ID']] = $ob['PROPERTY_SERIAL_NUMBER_VALUE'];
    }

    foreach ($res as $k => $v) {

        if(in_array($v[15], $serials)){
            $id = array_search($v[15], $serials);
            $dbres = $DB->Query("update b_iblock_element SET NAME = '$v[16]' WHERE ID = $id;", true);
            echo 'ID: '.$id.' update<br/>';
        }
        else{
            $dbres = $DB->Query("insert into b_iblock_element (IBLOCK_ID, ACTIVE, SORT, NAME) values (\"6\", \"Y\", \"500\", '$v[16]')", true);
            $id = $DB->LastID();
            echo 'ID: '.$id.' insert<br/>';
        }
        foreach ($v as $kk => $vv) {
            updateOrInsertProp($v[$kk], $kk, $id, $DB);
        }
    }
}

function ParseBanks($userId){

    $el = new CIBlockElement;

    $conn = ConnectToOracleDB();
    $query = 'SELECT * FROM ORGANIZATIONS_HB';
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
    
    // get all existing banks
    $arFilter = Array("IBLOCK_ID"=>10);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, array());
    $banks = array();
    while($ob = $res->GetNext())
    {
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();
        
        if($arProps['ORA_ID']['VALUE'] != ''){
            $banks[$arProps['ORA_ID']['VALUE']] = array();
            $banks[$arProps['ORA_ID']['VALUE']]['EXIST'] = 'Y';
            $banks[$arProps['ORA_ID']['VALUE']]['ID'] = $arFields['ID'];
        }
    }

    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {

        $PROP = array();
        $PROP[47] = $row['ID'];
        $PROP[48] = $row['PRFX'];

        $arLoadProductArray = Array(
            "MODIFIED_BY"    => $userId,
            "IBLOCK_ID"      => 10,
            "PROPERTY_VALUES"=> $PROP,
            "NAME"           => $row['NAME'],
            "ACTIVE"         => "Y"
        );

        if($banks[$row['ID']]['EXIST'] != 'Y') {

            if($PRODUCT_ID = $el->Add($arLoadProductArray))
                echo $PRODUCT_ID.' bank added<br/>';
            else
                echo "Failed to create a bank: ".$el->LAST_ERROR.'<br/>';
        }
        else{
            $updateRes = $el->Update($banks[$row['ID']]['ID'], $arLoadProductArray);
            if($updateRes){
                echo 'Bank '.$row['NAME'].' updated. id: '.$banks[$row['ID']]['ID'].'<br/>';
            }
            else{
                echo 'Error updating - Bank '.$row['NAME'].'<br/>';   
            }
        }
    }    
}


if($_REQUEST['page'] == '') {
    ?> <a href="/?page=1">Start</a> <?
}
else{
    $start = microtime(true);
    
    $connstart = microtime(true);
    $conn = ConnectToOracleDB();
    $time = microtime(true) - $connstart;
    printf('Подключились к Oracle за %.2F сек.<br/>', $time);
    if($_REQUEST['all_pages'] == ''){
        $products = GetProductsCount($conn);
        $_REQUEST['all_pages'] = ceil($products / PAGE_SIZE);
    }

    if($_REQUEST['page'] > $_REQUEST['all_pages']){
        echo 'Parse banks...<br/>';
        ParseBanks($USER->GetID());
        echo 'Parse banks done';
        oci_close($conn);
        return false;
    }

    echo "Page № ".$_REQUEST['page'].' from '.$_REQUEST['all_pages'].'<br/>';

    $res = array('serial' => $_REQUEST['serial'], 'count' => PAGE_SIZE);

    $res = getProductsFrom($USER->GetID(), $conn, $res['serial'], $DB);

    $_REQUEST['page']++;

    if($res['count'] <= PAGE_SIZE) {
        ?><script>var url = "/?serial=" + "<?=$res['serial']?>" + "&page=" + "<?=$_REQUEST['page']?>" + '&all_pages=' + "<?=$_REQUEST['all_pages']?>";</script><? 
    }
    $time = microtime(true) - $start;
    printf('Страница отработана за %.2F сек.<br/>', $time);
}
?>
<script>
    $(function(){
        setTimeout(function(){
            if(url) window.location.replace(url);
        }, 1000);
        
    });
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>