<div id="wrap-right">
    <form method="POST" action="<?php echo $URL.'&action=save'; ?>" >
        <div class="block-header">Изменение пароля</div>
  		<div class="block">
  			<table cellspacing="0" cellpadding="0" class="block" width="100%">
  			<tr>
  				<td class="text">Ваш логин</td>
  				<td>
  					<input type="text" class="text" name="login" value="<?php if(isset($_SESSION['login'])) echo $_SESSION['login']; ?>" />
  				</td>
  			</tr>
  			<tr>
  				<td class="text">Введите старый пароль</td>
  				<td>
  					<input type="password" class="text" name="oldpass" />
  				</td>
  			</tr>
   			<tr>
  				<td class="text">Новый пароль</td>
  				<td>
  					<input type="password" class="text" name="newpass" />
  				</td>
  			</tr>
   			<tr>
  				<td class="text">Повторите новый пароль</td>
  				<td>
  					<input type="password" class="text" name="newpass2" />
  				</td>
  			</tr>
  			</table>
  		</div>
        <input class="btn btn-inverse clear" type="submit" name="submit" value="Сохранить" />
    </form>
</div>