

<div class="footer"></div>

<div class="popup-box" id="popup-box-3">

	<div class="popup-title-1">Новый пользователь</div>

	<form id="add-form">

		<div class="row">
			<div class="label">Фамилия</div>
			<input type="text" name="secondName" class="text" placeholder="Введите фамилию">
		</div>

		<div class="row">
			<div class="label">Имя, Отчество</div>
			<input type="text" name="firstName" class="text" placeholder="Введите имя">
		</div>

		<div class="row">
			<div class="label">Логин (e-mail)</div>
			<input type="text" name="email" class="text" placeholder="Введите логин пользователя">
		</div>

		<div class="help-line">Пароль будет выслан на почту</div>
		<div id="changablePopupDiv">
			<div class="row">
				<div class="label">Группы</div>
				<div class="banks-selector">
					<div class="no-aval">
						<select name="group" id="bank-2-variants-sel" placeholder="Введите филиал банка...">
							<option value="">Введите филиал банка...</option>
							<?
								$res = CGroup::GetList(); 
								$groups = array(); 
								while ($g = $res->GetNext()):?>
									<option value="<?=$g['ID']?>"><?=$g['NAME']?></option>
								<? endwhile ?>

						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="popup-button">
			<button class="btn-blue">Добавить</button>
		</div>

		<input type="hidden" value="Y" name="addUser" />
		<div class="close"></div>

	</form>

</div>

<div class="popup-box" id="popup-box-4">

	<div class="popup-title-1">Новая группа пользователей</div>

	<form id="add-form">

		<div class="row">
			<div class="label">Наименование</div>
			<input type="text" name="name" class="text" placeholder="Введите название группы">
		</div>

		<div class="row">
			<div class="label">Описание</div>
			<textarea name="description" placeholder="Введите описание"></textarea>
		</div>

		<div class="popup-button">
			<button class="btn-blue">Сохранить</button>
		</div>

		<input type="hidden" value="Y" name="addGroup" />
		<div class="close"></div>

	</form>

</div>

<div class="popup-box" id="popup-box-5">

	<form id="delete-form">
		<input type="hidden" name="deleteUser" value="Y">
		<input type="hidden" name="user" value="<?=$_REQUEST['user']?>">
		<div class="delete-title">Вы действительно хотите удалить профиль?</div>

		<div class="buttons">

			<button class="btn-red-dashed">Удалить профиль</button>
			<button class="btn-blue">Отмена</button>

		</div>

		<div class="close"></div>

	</form>
	<script>
		$(function(){
			$('#delete-form .btn-blue').on('click', function(){
				$('#delete-form .close').click();
				return false;
			});
		});
	</script>

</div>
<?
	// delete user block
	if($_REQUEST['deleteUser'] == "Y" && $_REQUEST['user'] != ''){
		global $USER;
		if($USER->IsAdmin()){
			if (CUser::Delete($_REQUEST['user'])) { 
				header('Location: /settings/');
				exit;
			}
		}
	}
	// end delete user block

    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.min.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/selectize.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-ui.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/bootstrap-tagsinput.min.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/datepicker-ru.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/common.js');
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/cssrefresh11.js');
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/add.js');

?>

</body>

</html>