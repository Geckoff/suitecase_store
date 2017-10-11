<script>
        function createUploader(){
            var uploader = new qq.FileUploader({
                element: $('#img_upload')[0],
                action: 'fuploader.php',
                allowedExtensions: ['jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF'],
                multiple: false,
                sizeLimit: 5000000,
                minSizeLimit: 0,
                debug: false,
                autoUpload:true,
                onSubmit: function(id, fileName){$('#img_upload').show();},
                onProgress: function(id, fileName, loaded, total){},
                onComplete: function(id, fileName, responseJSON){ var name=responseJSON.filename; $(".images").append(getImage(name));},
                onCancel: function(id, fileName){},
                onError: function(id, fileName, xhr){}
            });

        }
        function getImage(name)
        {
			$(".qq-upload-button").hide();
            return '<li><div><img width="200px" src="<?php echo $FILE["temp"]; ?>'+name+'"><input type="hidden" name="image" value="'+name+'"></td><td><span class="del"><img src="img/delete.png"></span></div></li>';
        }
        $('.del').live('click',function()
        {

            $(this).closest('li').remove();
            $('.qq-upload-button').show();
            createUploader();
        });
        $(function()
        {
            createUploader();

        });
</script>
<div id="wrap-right">
  <form method="POST" action="<?php echo $URL; ?>&action=save" enctype="multipart/form-data">

  	<div id="tabs-1">
  		<div class="block-header">Свойства</div>
  		<div class="block">
  			<table cellspacing="0" cellpadding="0" class="block" width="100%">
  			<tr>
  				<td class="text">Заголовок</td>
  				<td>
  					<input type="text" name="title" value="<?php if (isset($_Slider_item[0]['title'])) print htmlspecialchars($_Slider_item[0]['title']); ?>" />
  				</td>
  			</tr>
              <?php
                if($Config['description']) {
                   if (isset($_Slider_item[0]['description'])) $_text = $_Slider_item[0]['description']; else $_text = '';
                    echo '
                    <tr>
                        <td class="text">Краткое описание</td>
                        <td>
                            <textarea rows="5" name="description">'.$_text.'</textarea>
                        </td>
                    </tr>';
                }
                if($Config['url']) {
                   if (isset($_Slider_item[0]['url'])) $_url = $_Slider_item[0]['url']; else $_url = '';
                    echo '
                    <tr>
                        <td class="text">Ссылка</td>
                        <td>
                            <input type="text" name="url" value="'.$_url.'" />
                        </td>
                    </tr>';
                }
              ?>
  			</table>
  		</div>

      <div class="block-header">Изображение</div>
    		<div class="block">
    			<table cellspacing="0" cellpadding="0" class="block" width="100%">

          <?php if(isset($_Slider_item[0]['image']) && $_Slider_item[0]['image'] != '') { ?>
    			<tr>
    				<td class="text"><?php echo (isset($_Slider_item[0]['image']) && $_Slider_item[0]['image'] != '' ? 'Текущее изображение' : ''); ?></td>
    				<td>
    				    <?php echo (isset($_Slider_item[0]['image']) && $_Slider_item[0]['image'] != '' ? '<img src="../data/slider/original/'.$_Slider_item[0]['image'].'" width="500px;"/>' : ''); ?>
    				</td>
    			</tr>
          <?php } ?>
			<tr>
				<ul class='images'>
                </ul>
			</tr>
    			<tr>

    				<td>
						<div id='img_upload' >
						</div>
    				</td>
    				<td class="text"></td>
    			</tr>
    			</table>
    		</div>
			<div style="clear:both;"></div>
       		<input type="submit" class="btn btn-inverse clear" name="submit" value="Сохранить" />
  	</div>
    <?php

		if(isset($_Slider_item[0]['parent'])){
			?>
				<input type="hidden" name="id" value="<?php if (isset($G['id'])) echo $G['id']; ?>" />
				<input type="hidden" name="parent" value="<?php if (isset($_Slider_item[0]['parent'])) echo $_Slider_item[0]['parent']; ?>" />
			<?php
		}
		else{
			if(isset($G['parent'])){
				?>
					<input type="hidden" name="id" value="<?php if (isset($G['id'])) echo $G['id']; ?>" />
					<input type="hidden" name="parent" value="<?php if (isset($G['parent'])) echo $G['parent']; ?>" />
				<?php
			}
		}
    ?>
  </form>

</div>
