<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Настройки");
?>

<div class="wrapper2">

	<div class="content2">
	
		<div class="breadcrumbs">
			<a href="#">Главная</a> <span></span> Настройки
		</div>

		<h1>Настройки</h1>

		<div class="tabs setting">
			<input id="tab1" type="radio" name="tabs" checked>
			<label for="tab1"><span>Пользователи</span></label>

			<input id="tab2" type="radio" name="tabs">
			<label for="tab2"><span>Группы</span></label>

			<section id="content1">

				<div class="inner">
					<?
						$rsGroups = CGroup::GetList(($by="id"), ($order="desc"), Array()); 
						$pageSize = 6;
						$rsGroups->NavStart($pageSize);
						$groups = array();
						while($ob = $rsGroups->GetNext()){
							$groups[$ob['ID']] = array($ob['NAME'], $ob['DESCRIPTION']);
						}

						$res = CUser::GetUserGroupList($ob['ID']);

						$rsUsers = CUser::GetList();
						
						$rsUsers->NavStart($pageSize);

						$users = array();
						while($ob = $rsUsers->GetNext()){
							$obj = array();
							$obj['ID'] = $ob['ID'];
							$obj['NAME'] = $ob['NAME'].' '.$ob['LAST_NAME'];
							$obj['EMAIL'] = $ob['EMAIL'];
							$obj['SECOND_NAME'] = $ob['SECOND_NAME'];
							$resGr = CUser::GetUserGroupList($ob['ID']);
							while($gr = $resGr->GetNext()){
								$obj['GROUPS'][] = $gr['GROUP_ID'];
							}
							$users[] = $obj;
						}
					?>
					<?if(count($users) == 0):?>
						<div class="setting-empty">
							<div class="empty-title">Пока что ни одного пользователя не существует</div>
							<div class="empty-avatar"><img src="images/avatar.png" alt=""></div>
							<a href="#" class="add user popup-link-3">Добавить пользователя <i></i></a>
						</div>
					<?else:?>
						<div class="settings">

						<a href="#" class="add user right popup-link-3">Добавить пользователя <i></i></a>
						<div class="clear"></div>
						<table class="all-banks-table">
							<tr>
								<th>ФИО пользователя</th>
								<th>Логин пользователя (e-mail)</th>
								<th>Группы</th>
								<th>Действия</th>
							</tr>
							<?foreach ($users as $k => $v):?>

								<tr>
									<td><?=$v['NAME']?></td>
									<td><?=$v['EMAIL']?></td>
									<td>
										<?foreach ($v['GROUPS'] as $kk => $vv):?>
											<?=$groups[$vv][0].' '?>
										<?endforeach?>
									</td>
									<td>
										<a href="/settings/user/?user=<?=$v['ID']?>" class="edit"></a>
										<a href="#" data-userid="<?=$v['ID']?>" class="userdelete delete"></a>
									</td>
								</tr>

							<?endforeach?>
						</table>
						<div id="customPagination" style="display: none;">
						<?=$rsUsers->NavPrint("", false, "text");?>
						</div>

						<div class="page-nav">
							<div class="numbers" id="pageinserthere">
								
							</div>
						</div>

						<script type="text/javascript">
							$(function(){
								var pages = [];
								$('.userdelete.delete').on('click', function(){
									$('#popup-box-5').show();
									$('#blackout').show();
									$("#delete-form input[name='user']").val($(this).data('userid'));
									return false;
								});
								$('#customPagination a').each(function(){
									var val = parseInt($(this).text());
									if(val){
										pages.push($(this));	
									}
								});
								$("#pageinserthere").html(pages);
							});
						</script>
					</div>
					<?endif;?>
				</div>

			</section>

			<section id="content2">

				<div class="inner">
					<?if(count($groups) == 0):?>
						<div class="setting-empty">
							<div class="empty-title">Пока что ни одной группы не существует</div>
							<div class="empty-avatar"><img src="images/group.png" alt=""></div>
							<a href="#" class="add group popup-link-4">Новая группа <i></i></a>
						</div>
					<?else:?>
						<div class="settings">

						<a href="#" class="add group right popup-link-4">Новая группа <i></i></a>
						<div class="clear"></div>

						<table class="all-banks-table">
							<tr>
								<th>Наименование</th>
								<th>Описание</th>
							</tr>
							<?foreach ($groups as $k => $v):?>
								<tr>
									<td><?=$v[0]?></td>
									<td><?=$v[1]?></td>
									<td>
										<a href="#" class="edit"></a>
										<a href="#" class="delete"></a>
									</td>
								</tr>
							<?endforeach?>
						</table>


						<div id="customPaginationGroups" style="display: none;">
						<?=$rsGroups->NavPrint("", false, "text");?>
						</div>

						<div class="page-nav">
							<div class="numbers" id="pageinsertheregroups">
								
							</div>
						</div>

						<script type="text/javascript">
							$(function(){
								var pages = [];
								$('#customPaginationGroups a').each(function(){
									var val = parseInt($(this).text());
									if(val){
										pages.push($(this));	
									}
								});
								$("#pageinsertheregroups").html(pages);
							});
						</script>

					</div>
					<?endif;?>

				</div>

			</section>

		</div>

	</div><!-- end content2 -->

</div>
<script type="text/javascript">

	function validateEmail(email) {
	    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	    return re.test(email);
	}

	$(function(){

		history.pushState('', 'Настройки', window.location.origin + window.location.pathname);

		$("#popup-box-4 .btn-blue").on('click', function(e){

			e.preventDefault();
			e.stopPropagation();

			pr = false;
			if($('#popup-box-4 input[name="name"]').val().length == 0){
				$('#popup-box-4 input[name="name"]').css('border', '1px solid red');
				pr = true;
			}
			else{
				$('#popup-box-4 input[name="name"]').css('border', '1px solid #e0e0e0');
			}
			if(pr) return false;

			$(this).parents('form').submit();
		});
		$("#popup-box-3 .btn-blue").on('click', function(e){

			e.preventDefault();
			e.stopPropagation();

			pr = false;
			if(!validateEmail($('#popup-box-3 input[name="email"]').val())){
				$('#popup-box-3 input[name="email"]').css('border', '1px solid red');
				pr = true;
			}
			else{
				$('#popup-box-3 input[name="email"]').css('border', '1px solid #e0e0e0');
			}
			if(pr) return false;

			$(this).parents('form').submit();
		});

	});
</script>
<?
	if($_REQUEST['addGroup'] == "Y"){
		$group = new CGroup;
		$arFields = Array(
		  "ACTIVE"       => "Y",
		  "NAME"         => $_REQUEST['name'],
		  "DESCRIPTION"  => $_REQUEST['description']
		);
		$result = $group->Add($arFields);
		//if (strlen($group->LAST_ERROR)>0) $result = $group->LAST_ERROR;
	}
	if($_REQUEST['addUser'] == "Y"){

	    if (CModule::IncludeModule("main"))
	    {
	    	$user = new CUser;
	    	$pass = generateRandomString(8);
			$arFields = Array(
			  "NAME"              => $_REQUEST['secondName'],
			  "LAST_NAME"         => $_REQUEST['firstName'],
			  "EMAIL"             => $_REQUEST['email'],
			  "LOGIN"             => $_REQUEST['email'],
			  "LID"               => "ru",
			  "ACTIVE"            => "Y",
			  "GROUP_ID"          => array($_REQUEST['group']),
			  "PASSWORD"          => $pass,
			  "CONFIRM_PASSWORD"  => $pass
			);

			$ID = $user->Add($arFields);

	    	$mailFields = array(
				"FIRSTNAME" => $_REQUEST['firstName'],
		      	"SECONDNAME" => $_REQUEST['secondName'],
		      	"EMAIL" => $_REQUEST['email'],
		      	"GROUP" => $_REQUEST['group'],
				"PASS" => $pass
		    );

			CEvent::SendImmediate("WELCOME_MESSAGE", "s1", $mailFields);
		}
	}

?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
