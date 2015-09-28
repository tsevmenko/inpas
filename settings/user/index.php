<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройки пользователя");

if($_REQUEST['user'] == '') {
	echo 'Пользователь не найден';
	return false;
}

function isUserPassword($userId, $password)
{
    $userData = CUser::GetByID($userId)->Fetch();

    $salt = substr($userData['PASSWORD'], 0, (strlen($userData['PASSWORD']) - 32));

    $realPassword = substr($userData['PASSWORD'], -32);
    $password = md5($salt.$password);

    return ($password == $realPassword);
}

// send block

if($_REQUEST['submit'] == 'Y'){
	$errors = "";
	if(isUserPassword($_REQUEST['user'], $_REQUEST['old_password'])){
		$user = new CUser;
		if($_REQUEST['new_password'] == $_REQUEST['new_password_confirm'] && 
		   $_REQUEST['new_password'] == ""){
			$_REQUEST['new_password'] = $_REQUEST['old_password'];
		}
		if(strlen($_REQUEST['groups']) > 0)
			$_REQUEST['groups'] = explode(',', $_REQUEST['groups']);
		else 
			$_REQUEST['groups'] = "1";
		$fields = Array(
		  "EMAIL"             => $_REQUEST['email'],
		  "GROUP_ID"          => $_REQUEST['groups'],
		  "PASSWORD"          => $_REQUEST['new_password'],
		  "CONFIRM_PASSWORD"  => $_REQUEST['new_password'],
		  "PERSONAL_CITY"	  => $_REQUEST['address']
		);
		if(!$user->Update($_REQUEST['user'], $fields)) $errors .= $user->LAST_ERROR;
	}
	else{
		$errors .= "Введен неверный старый пароль.<br/>";
	}
}

// end send block

$rsGroups = CGroup::GetList(($by="id"), ($order="asc"), Array()); 
$groups = array();
while($ob = $rsGroups->GetNext()){
	$groups[$ob['ID']] = array(str_replace(',', ' ', $ob['NAME']), $ob['DESCRIPTION']);
}


$filter = array("ID" => $_REQUEST['user']);
$rsUsers = CUser::GetList(($by="id"), ($order="asc"), $filter);

$user = array();

while($ob = $rsUsers->GetNext()){

	$user['ID'] = $ob['ID'];
	$user['NAME'] = $ob['LAST_NAME'].' '.$ob['NAME'];
	$user['EMAIL'] = $ob['EMAIL'];
	$user['PERSONAL_CITY'] = $ob['PERSONAL_CITY'];
	$resGr = CUser::GetUserGroupList($ob['ID']);
	$user['GROUPS'] = array();
	while($gr = $resGr->GetNext()){
		$user['GROUPS'][] = $gr['GROUP_ID'];
	}
	break;
}
    
?>

<div class="wrapper2">

	<div class="content2">
	
		<div class="breadcrumbs">
			<a href="#">Главная</a> <span></span> Профиль пользователя
		</div>

		<h1>Профиль пользователя</h1>
		
		<?if($errors != ''):?>
			<div class="ui">
				<div class="col-1 alert-col" style="margin: 0px;">
					<div class="alert red">
						<?=$errors?>
						<div class="alert-close">×</div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
		<?else:?>
			<?if($_REQUEST['submit'] == 'Y'):?>
				<div class="ui">
					<div class="col-1 alert-col" style="margin: 0px;">
						<div class="alert green">
							Запись пользователя успешно обновлена
							<div class="alert-close">×</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			<?endif;?>
		<?endif;?>

		<div class="setting-user">

			<h2><?=$user['NAME']?></h2>



			<form id="user-form">

				<div class="row">
					<div class="label">Электронный адрес</div>
					<input type="text" name="email" value="<?=$user['EMAIL']?>" placeholder="Введите ваш e-mail">
				</div>

				<div class="row">
					<div class="label">Почтовый адрес</div>
					<input type="text" name="address" value="<?if($user['PERSONAL_CITY'] != '') echo $user['PERSONAL_CITY']?>" placeholder="Введите адрес">
				</div>

				<div class="gray-line"></div>

				<h3>Укажите группы, в которых состоит пользователь:</h3>
				
				<div class="no-aval tags-select">
					<select id="bank-2-variants-selsu" placeholder="Сбербанк">
						<?$groupsVal = ""?>
						<?foreach ($groups as $key => $value) :?>
							<?
							if(in_array($key, $user['GROUPS'])){
								$groupsVal .= str_replace(',', ' ', $groups[$key][0]).',';
							}
							?>
							<option value="<?=$key?>"><?=$groups[$key][0]?></option>
						<?endforeach?>
					</select>

					<div id="taginput">
						<input type="text"  class="serial su-tags" value="<?=$groupsVal?>" placeholder="Введите группу...">
					</div>
				</div>

				<div class="gray-line"></div>

				<h3>Сменить пароль</h3>

				<div class="row">
					<div class="label">Введите старый пароль</div>
					<input type="text" name="old_password">
				</div>

				<div class="row">
					<div class="label">Новый пароль</div>
					<input type="text" name="new_password">
				</div>

				<div class="row">
					<div class="label">Повторить новый пароль</div>
					<input type="text" name="new_password_confirm">
				</div>

				<div class="buttons">

					<button class="btn-blue">Сохранить</button>
					<button class="btn-red-dashed popup-link-5">Удалить профиль</button>

				</div>

				<input type="hidden" name="submit" value="Y">
				<input type="hidden" name="groups" id="userNewGroups">
				<input type="hidden" name="user" value="<?=$_REQUEST['user']?>">
			</form>

		</div>
	
	</div><!-- end content2 -->

</div>

<script type="text/javascript">
	
	var existGroups = JSON.parse('<?=json_encode($groups)?>');

	function validateEmail(email) {
	    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	    return re.test(email);
	}

	$(function(){	

		$('#user-form .buttons .btn-blue').on('click', function(){
			
			var pr = false;

			if(!validateEmail($('#user-form input[name="email"]').val())){
				$('#user-form input[name="email"]').css('border', '1px solid red');
				pr = true;
			}
			else{
				$('#user-form input[name="email"]').css('border', '1px solid #e0e0e0');
			}

			var groups = [];
			var groupsId = [];
			$('.tag.label.label-info').each(function(){
				groups.push($(this).text());
			});
			
			for(v in existGroups){
				if(groups.indexOf(existGroups[v][0]) != -1){
					groupsId.push(v);
				}
			}
			var old_password = $('#user-form input[name="old_password"]');
			var new_password = $('#user-form input[name="new_password"]');
			var new_password_confirm = $('#user-form input[name="new_password_confirm"]');
			// if old password input was filled
			if(old_password.val().length == 0){
				old_password.css('border', '1px solid red');
				pr = true;
			}
			else{
				old_password.css('border', '1px solid #e0e0e0');
			}
			// if new password input equals confirm password input
			if(new_password.val() != '' && new_password_confirm.val() != ''){
				if(	new_password.val() != new_password_confirm.val() ||
					new_password.val().length == 0 ||
					new_password_confirm.val().length == 0 ){

					new_password.css('border', '1px solid red');
					new_password_confirm.css('border', '1px solid red');
					pr = true;
				}
				else{
					new_password.css('border', '1px solid #e0e0e0;');
					new_password_confirm.css('border', '1px solid #e0e0e0');
				}
			}

			if(pr) return false;

			$('#userNewGroups').val(groupsId);
		});
		
	});
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>