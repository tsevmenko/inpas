<!DOCTYPE HTML>
<html id="html">

<head>
    <meta charset="utf-8">
    <title><?$APPLICATION->ShowTitle();?></title>
    
<?
    $APPLICATION->ShowHead();

    $APPLICATION->AddHeadString('<meta name="description" content="">');
    $APPLICATION->AddHeadString('<meta name="viewport" content="width=device-width, initial-scale=1">');

    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/jquery-ui.css');
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/style.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/tabs.css');
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/selectize.css');

    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/bootstrap-tagsinput.css');
?>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>

<div id="panel"><?$APPLICATION->ShowPanel();?></div>

<div class="nav">

    <div class="wrapper">

        <a href="/" class="logo"></a>

        <?$APPLICATION->IncludeComponent("bitrix:menu", "left-main-menu", Array(
                "COMPONENT_TEMPLATE" => ".default",
                "ROOT_MENU_TYPE" => "top-right",    // Тип меню для первого уровня
                "MENU_CACHE_TYPE" => "Y",   // Тип кеширования
                "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                "MENU_CACHE_USE_GROUPS" => "Y", // Учитывать права доступа
                "MENU_CACHE_GET_VARS" => array( // Значимые переменные запроса
                    0 => "",
                ),
                "MAX_LEVEL" => "1", // Уровень вложенности меню
                "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                "USE_EXT" => "N",   // Подключать файлы с именами вида .тип_меню.menu_ext.php
                "DELAY" => "N", // Откладывать выполнение шаблона меню
                "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
            ),
            false
        );?>

        <?$APPLICATION->IncludeComponent(
            "bitrix:menu", 
            "right-main-menu", 
            array(
                "COMPONENT_TEMPLATE" => "right-main-menu",
                "ROOT_MENU_TYPE" => "top-left",
                "MENU_CACHE_TYPE" => "Y",
                "MENU_CACHE_TIME" => "3600",
                "MENU_CACHE_USE_GROUPS" => "Y",
                "MENU_CACHE_GET_VARS" => array(
                ),
                "MAX_LEVEL" => "1",
                "CHILD_MENU_TYPE" => "left",
                "USE_EXT" => "N",
                "DELAY" => "N",
                "ALLOW_MULTI_SELECT" => "N"
            ),
            false
        );?>

    </div>

</div>

<div class="menu">

    <div class="wrapper">

        <ul class="menu-list">
			<li><a href="/otchet-po-banku/">Отчёт по банку</a></li>
            <li><a href="/otchet-po-nomeru-scheta/">Отчёт по номеру счёта</a></li>
			<li><a href="/report-sent-equipment/">Отгруженное оборудование</a></li>
            <li><a href="/oborudovanie-v-service/">Оборудование в сервисе</a></li>
			<li><a href="/report-serial-number/">По серийным номерам</a></li>
			<li><a href="/report-all-fixes/">Все ремонты клиента</a></li>
        </ul>

    </div>

</div>