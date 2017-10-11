<div id="wrap-right">

  <form method="POST" action="<?php echo $URL; ?>&action=save_slider" enctype="multipart/form-data">

  	<div id="tabs-1">
  		<div class="block-header">Свойства</div>
  		<div class="block">
  			<table cellspacing="0" cellpadding="0" class="block" width="100%">
  			<tr>
  				<td class="text">Заголовок слайдера</td>
  				<td>
  					<input type="text" name="title" value="<?php if (isset($_Slider_item[0]['title'])) print htmlspecialchars($_Slider_item[0]['title']); ?>" />
  				</td>
  			</tr>
  			</table>
  		</div>

        <input type="submit" class="btn btn-inverse clear" name="submit" value="Сохранить" />
  	</div>

    <input type="hidden" name="id" value="<?php if (isset($G['id'])) print $G['id']; ?>" />

  </form>
  
</div>
