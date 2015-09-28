<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

$conn = ConnectToOracleDB();
$_SESSION['BANKID'] = $arResult['PROPERTIES']['ORA_ID']['VALUE'];
$query = 'SELECT ship.SERIAL_NUM,eq.NAME,ship.CUSTOMER_ID,TO_CHAR( ship.DATA_REG, \'dd.mm.yyyy\' ) as DATA_REG,TO_CHAR( ship.WARRANTY, \'dd.mm.yyyy\' ) as WARRANTY, (SELECT NAME FROM STATUS_HB WHERE ID = ship.STATUS_ID) as STATUS,ship.INVOICE,ship.WAYBILL,eq.PARTNUM,eq.NAME FROM EQUIPMENT_HB eq, TERM_SHIPP ship WHERE eq.PARTNUM = ship.TYPE_EQUIP AND ship.CUSTOMER_ID = \''.$arResult['PROPERTIES']['ORA_ID']['VALUE'].'\' ORDER BY ship.SERIAL_NUM';

$stid = oracleQueryExecute(ConnectToOracleDB(), $query);

$equipment = array();
$equipment['TOTAL_COUNT'] = 0;
$equipment['WARRANTY_COUNT'] = 0;
$equipment['WITHOUT_WARRANTY_COUNT'] = 0;
$equipment['IN_SERVICE'] = 0;

$query = 'select * from servise_all where serial_number in (';
$_SESSION['devices'] = array();
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	$equipment[$row['NAME']][$row['SERIAL_NUM']] = $row;
	$_SESSION['devices'][] = $row['SERIAL_NUM'];
	$query .= '\''.implode('-',str_split($row['SERIAL_NUM'], 3)).'\'';
	$query .= ', ';
}
$query = substr_replace($query ,"",-2);
$query .= ')';

$msdate = GetMSSQLData(ConnectToMSSQL(), $query);
// $k - serial num
foreach($msdate as $k => $v){
	// $kk - type
	foreach($equipment as $kk => $vv){
		if(array_key_exists($k, $vv)){
			$equipment[$kk][$k]['MAIN_STATUS'] = $msdate[$k]['MAIN_STATUS'];
		}
	}
}
foreach($equipment as $k => $v){

	foreach($v as $kk => $vv){
		$equipment['TOTAL_COUNT']++;
		$equipment[$k]['TOTAL_COUNT']++;

		if(time() <= strtotime($vv['WARRANTY'])){
			$equipment['WARRANTY_COUNT']++;
			$equipment[$k]['WARRANTY_COUNT']++;
		}
		else{
			$equipment['WITHOUT_WARRANTY_COUNT']++;
			$equipment[$k]['WITHOUT_WARRANTY_COUNT']++;
		}
		if($vv['MAIN_STATUS'] == "Выдано/отправлено" || $vv['MAIN_STATUS'] == ""){
			$equipment['IN_SERVICE']++;
			$equipment[$k]['IN_SERVICE']++;
		}
	}
	$equipment[$k]['IN_SERVICE'] = $equipment[$k]['TOTAL_COUNT'] - $equipment[$k]['IN_SERVICE'];
}
$equipment['IN_SERVICE'] = $equipment['TOTAL_COUNT'] - $equipment['IN_SERVICE'];

odbc_close($connection);

?>
	<h1><?=$arResult['NAME']?> <span class="bank-logo">
		<?if($arResult['PREVIEW_PICTURE']['SRC'] != ''):?>
			<img src="<?=$arResult['PREVIEW_PICTURE']['SRC']?>" alt="<?=$arResult['NAME']?>">
		<?endif;?>
	</span></h1>

	<h3>Данные банка</h3>
	
	<a class="btn-gray right" href="#">Сформировать отчет по подразделению</a>
	
	<div class="clear"></div>
	
	<table class="all-banks-table4">
		<tr>
			<th>Тип оборудования</th>
			<th>Аппаратов отгружено <span><?=$equipment['TOTAL_COUNT']?></span></th>
			<th>Аппаратов на гарантии <span><?=$equipment['WARRANTY_COUNT']?></span></th>
			<th>Аппаратов без гарантии <span><?=$equipment['WITHOUT_WARRANTY_COUNT']?></span></th>
			<th>Аппаратов в сервисе <span><?=$equipment['IN_SERVICE']?></span></th>
		</tr>
		<?foreach ($equipment as $k => $v):?>
		<? if(is_array($v)): ?>
		<? 	if($v['TOTAL_COUNT'] == '') $v['TOTAL_COUNT'] = 0;
			if($v['WARRANTY_COUNT'] == '') $v['WARRANTY_COUNT'] = 0;
			if($v['WITHOUT_WARRANTY_COUNT'] == '') $v['WITHOUT_WARRANTY_COUNT'] = 0;
			if($v['IN_SERVICE'] == '') $v['IN_SERVICE'] = 0;
		?>
			<tr>
				<td><?=$k?></td>
				<td><?=$v['TOTAL_COUNT']?></td>
				<td><?=$v['WARRANTY_COUNT']?></td>
				<td><?=$v['WITHOUT_WARRANTY_COUNT']?></td>
				<td><?=$v['IN_SERVICE']?></td>
			</tr>	
		<? endif; ?>
		<?endforeach;?>

	</table>