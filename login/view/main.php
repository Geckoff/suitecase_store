<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
  	<title><?php echo $AdminConfig['CMS_VER_LOGO']; ?></title>
  	<base href="<?php echo $AdminConfig['HOST'].'/'.$_CMS_ENTER.'/'; ?>" />
    <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link href="css/fileuploader.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="css/datepicker.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        if (typeof jQuery == 'undefined') {
            document.write(unescape("%3Cscript src='js/jquery-1.8.3.min.js' type='text/javascript'%3E%3C/script%3E"));
        }
    </script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery-cookie.js"></script>
    <script type="text/javascript" src="js/fileuploader.js"></script>
    <script type="text/javascript" src="<?php echo $AdminConfig['HOST']; ?>/tinymce/tinymce.min.js"></script>
    <script type="text/javascript"> var module_id = '<?php echo $module; ?>';</script>
  	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
    <div class="subnavbar">
    	<div class="subnavbar-inner">
            <ul class="nav nav-pills">
                    <?php
                        $cntM = count($_Menu);
                        for ($i = 0; $i < $cntM; ++$i) {
                            if ($i == 0) {
                                echo '<li class="ico-home ',(($module === 'structure')? 'active': ''),'"><a href="module=',$_Menu[$i]['name'],'&action=blank" class="dropdown-toggle ico-home">Страницы</a></li>';
                                echo '<li class="dropdown ',(($module != 'structure' && $module != 'settings' && $module != 'repass')? 'active': ''),'">
                                        <a href="#" data-toggle="dropdown" role="button" id="drop1" class="dropdown-toggle ico-network">Разделы <b class="caret clear"></b></a>
                                        <ul aria-labelledby="drop2" role="menu" class="dropdown-menu" id="menu1">';
                            }
                            if ($_Menu[$i]['sort'] > 3) {
                                echo '<li><a href="module=',$_Menu[$i]['name'],'&action=blank" tabindex="-1">',$_Menu[$i]['title'],'</a></li>';
                            }
                            if ($i == $cntM - 1) {
                                echo '</ul>
                                    </li>';
                            }
                        }
                    ?>
                    <li class="dropdown <?php if ($module === 'settings' || $module === 'repass') echo 'active'; ?> ">
                        <a href="#" data-toggle="dropdown" role="button" id="drop2" class="dropdown-toggle ico-control">Настройка <b class="caret"></b></a>
                        <ul aria-labelledby="drop2" role="menu" class="dropdown-menu" id="menu2">
                            <li><a href="module=settings&action=blank" tabindex="-1">Общ. информация</a></li>
                            <li><a href="module=repass&action=blank" tabindex="-1">Смена пароля</a></li>
                        </ul>
                    </li>
            </ul>
            <a class="logout" href="logout">выход</a>
    	</div>
    </div>


    <div id="center_new_cms">

        <div id="center_left_new_cms">
            <div class="structLayout" id="structLayout">
                <div class="center_left_katalog">
                    <p><?php print $_LEFT['title']; ?></p>
                </div>
                <div class="center_left_sam_katalog">
                    <div class="content" id="content">
                        <?php
                            if (isset($_LEFT['message']) && $_LEFT['message'] != '') {
                                echo '<div class="alert alert-success">
                                    <a class="close" data-dismiss="alert">×</a>
                                    ',$_LEFT['message'],'
                                </div>';
                            }
                            if (isset($_LEFT['error']) && $_LEFT['error'] != '') {
                                echo '<div class="alert alert-error">
                                    <a class="close" data-dismiss="alert">×</a>
                                    <strong>Ошибка!</strong> ',$_LEFT['error'],'
                                </div>';
                            }
                            echo $_LEFT['content'];
                        ?>
                    </div>
                </div>
            </div>
        </div>
    
        <div id="center_right_new_cms">
            <div id="right_center_blok_verh">
                <div class="right_center_blok_verh_nazv">
                    <p><?php echo $_RIGHT['title']; ?></p>
                </div>
            </div>
            <div id="right_center_blok">
                <div class="right_center_block_nastroiki">
                    <?php
                    	if (isset($_SESSION['message']) && !empty($_SESSION['message']) && isset($msg) && $msg==1) {
                            echo '<div class="alert alert-success">
                                    <a class="close" data-dismiss="alert">×</a>
                                    ',$_SESSION['message'],'
                                </div>';
                    
                            unset($_SESSION['message']);
                        }
                    	if (isset($_SESSION['error']) && !empty($_SESSION['error']) && isset($msg) && $msg==1) {
                            echo '<div class="alert alert-error">
                                    <a class="close" data-dismiss="alert">×</a>
                                    <strong>Ошибка!</strong> ',$_SESSION['error'],'
                                </div>';
                            unset($_SESSION['error']);
                        }
                    	if (isset($_SESSION['error_no_location']) && !empty($_SESSION['error_no_location'])) {
                            echo '<div class="alert alert-error">
                                    <a class="close" data-dismiss="alert">×</a>
                                    <strong>Ошибка!</strong> ',$_SESSION['error_no_location'],'
                                </div>';
                            unset($_SESSION['error_no_location']);
                        }
                    	if (isset($_SESSION['info']) && !empty($_SESSION['info'])) {
                            echo '<div class="alert alert-info">
                                    <a class="close" data-dismiss="alert">×</a>
                                    ',$_SESSION['info'],'
                                </div>';
                            unset($_SESSION['info']);
                        }
                    	echo $_RIGHT['content'];
                    ?>
                </div>
            </div>
            <div class="copy">
                <p>&copy; Владелец <a target="_blank" href="http://fpro.by">ООО "Фабрика проектов"</a></p>
            </div>
        </div>
        
    </div>
    
  </body>
</html>
