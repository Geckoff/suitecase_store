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
			onComplete: function(id, fileName, responseJSON){ var name=responseJSON.filename; $("#imglist").append(getImage(name));},
			onCancel: function(id, fileName){},
			onError: function(id, fileName, xhr){}
		});

	}
	function getImage(name){	
		$('#imglist').empty();
		return '<li><div class="img-container">\
						<div class="img-cell"><img src="<?php echo $Config['dir']['tmp_dir']; ?>'+name+'"></div>\
						<input type="hidden" name="description[fname]" value="'+name+'"></div>\
						<span class="del"><img src="img/delete.png"></span></li>';
	}
	$(document).ready(function(){
		createUploader();
		
		$('.del').live('click',function(){
			if(confirm('Вы действительно хотите удалить это изображение?')){
				$(this).closest('li').remove();
				$('.qq-upload-button').show();
				createUploader();
			} else return false;
		});
	});
</script>
<div id="wrap-right">
	<form enctype="multipart/form-data" action="<?php echo $URL.'&action=tree_save&id='.$G['id']; ?>" method="post">
		<div class="block-header">Свойства</div>
		<div class="block">
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="text">Название</td>
					<td>
						<input type="text" name="description[title]" value="<?php if (isset($TREE['title'])) echo htmlspecialchars($TREE['title']); ?>" />
						<input type="hidden" name="description[fname]" value="" />
					</td>
				</tr>
				<tr>
					<td class="text">Описание</td>
					<td>
						<textarea name="description[description]" rows="5"><?php if (isset($TREE['description'])) echo htmlspecialchars($TREE['description']); ?></textarea> 
					</td>
				</tr>
				<tr>
					<td class="text">Изображение</td>
					<td>
						<ul id='imglist'>
						<?php
							if(isset($TREE['fname']) && !empty($TREE['fname'])){
								echo '<li>
										<div class="img-container">
											<div class="img-cell"><img src="'.$Config['dir']['data_dir'].'cms_original/'.$TREE['fname'].'"></div>
											<input type="hidden" name="description[fname]" value="'.$TREE['fname'].'">
										</div>
										<span class="del"><img src="img/delete.png"></span>
									</li>';
							}
						?>
						</ul>
						<div id='img_upload'></div>
					</td>
				</tr>
			</table>
		</div>
		<div class="block-header">Мета-теги для SEO-оптимизации</div>
		<div class="block">
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td class="text">Title (заголовок)</td>
					<td>
						<input type="text" name="seo[title]" value="<?php if (isset($TREE['seo_title'])) echo htmlspecialchars($TREE['seo_title']); ?>" />
					</td>
				</tr>
				<tr>
					<td class="text">Keywords (ключевые слова)</td>
					<td>
						<input type="text" name="seo[keywords]" value="<?php if (isset($TREE['seo_keywords'])) echo htmlspecialchars($TREE['seo_keywords']); ?>" />
					</td>
				</tr>
				<tr>
					<td class="text">Description (описание страницы)</td>
					<td>
						<textarea name="seo[description]" rows="5"><?php if (isset($TREE['seo_description'])) echo htmlspecialchars($TREE['seo_description']); ?></textarea> 
					</td>
				</tr>

			</table>
		</div>
		<input type="submit" class="btn btn-inverse clear" name="submit" value="Сохранить" />
	</form>
</div>