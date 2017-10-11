<?php
/*
 * @author ООО "Фабрика проектов"
 * @copyright 2013
 */
	session_start();
	include_once dirname(__FILE__).'/../config/admin_start.php';

	ob_start();
	if (isset($_SESSION['login']) && $_SESSION['login'] != '') {
		header('Location: start');
    }
	elseif (!empty($_POST)) {
		include_once dirname(__FILE__).'/include/auth.php';
    }

	if (!isset($_block)) {
		if(isset($_COOKIE['badUser']) && $_COOKIE['badUser'] != 'NULL') {
			$_block = true;
        }
		else {
			$_block = false;
        }
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Вход в CMS "Фабрика проектов"</title>
    <link href="img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
        if (typeof jQuery == 'undefined') {
            document.write(unescape("%3Cscript src='js/jquery-1.8.3.min.js' type='text/javascript'%3E%3C/script%3E"));
        }
    </script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="wrap-form">
	<?php
	       if(!$_block) {
	?>
        <a href="http://fpro.by" title='Собственность OOO "Фабрика проектов"' target="_blank"><img class="logo" src="img/logo-fpro.png" width="140" height="55" /></a>
        <form class="form-horizontal" action='' method="POST">
          <fieldset>
            <div id="legend">
              <legend>Авторизация в системе</legend>
            </div>
            <?php
                   if(isset($_message)) {
                            echo '<div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">x</button>',$_message,'
                                 </div>';
    			   }
	        ?>
            <div class="control-group">
              <!-- Username -->
              <label class="control-label"  for="username">Логин:</label>
              <div class="controls">
                <input autofocus="autofocus" type="text" id="username" name="username" placeholder="Введите логин..." class="input-xlarge" value="<?php if(isset($_POST['username'])) echo $_POST['username']; ?>" />
              </div>
            </div>

            <div class="control-group">
              <!-- Password-->
              <label class="control-label" for="password">Пароль:</label>
              <div class="controls">
                <input type="password" id="password" name="password" placeholder="Введите пароль..." class="input-xlarge" />
              </div>
            </div>

            <div class="control-group">
              <!-- Button -->
              <div class="controls">
                <button class="btn btn-info">Войти</button>
              </div>
            </div>
          </fieldset>
        </form>
	<?php
	   }
	   else {
	?>
			<p class="text-error">Мы временно ограничили Вам доступ.</p>
			<p>Через <span id="time-block">10</span> <span id="min">минут</span> попробуйте войти снова.</p>
            <br />
            <blockquote>&copy; Собственность <a href="http://fpro.by" target="_blank">ООО "Фабрика проектов"</a></blockquote>
	
    <script type="text/javascript">
		var last_time = <?php if(!isset($_COOKIE['badUser'])) {
								echo $_SESSION['time'];
								unset ($_SESSION['time']);
							}
							else {
								echo $_COOKIE['badUser'];
                            }
                        ?>;
		var date = new Date();
		var now_time = date.getTime();
		var obj = document.getElementById("time-block");
		var objmin = document.getElementById("min");
		function min_verify() {
			if (parseInt(obj.innerHTML) >= 2 && parseInt(obj.innerHTML) <= 4)
				objmin.innerHTML = 'минуты';
			if (parseInt(obj.innerHTML) == 1)
				objmin.innerHTML = 'минуту';
		}
		obj.innerHTML = 10 - (((now_time/1000).toFixed(0) - last_time)/60).toFixed(0);
		if (parseInt(obj.innerHTML) < 0)
			obj.innerHTML = '0';
		min_verify();
		setInterval(function(){
			if (parseInt(obj.innerHTML) > 0)
				obj.innerHTML = parseInt(obj.innerHTML) - 1;
			if(parseInt(obj.innerHTML) == 0)
				window.location.href = '/login';
			min_verify();
		}, 60000);
	</script>
	<?php
	   }
	   ob_end_flush();
	?>
    </div>
</body>
</html>