<script>
	function createImgUploader(){
		var uploader = new qq.FileUploader({
			element: $('#img_upload')[0],
			action: 'fuploader.php',
			allowedExtensions: ['jpg','jpeg','png','gif','JPG','JPEG','PNG','GIF'],
			multiple: true,
			sizeLimit: 5000000,
			minSizeLimit: 0,
			debug: false,
			autoUpload:true,
			onSubmit: function(id, fileName){$('#img_upload').show();},
			onProgress: function(id, fileName, loaded, total){},
			onComplete: function(id, fileName, responseJSON){ var name=responseJSON.filename; $("#imglist").append(getImage(name));$('.primary').tooltip();},
			onCancel: function(id, fileName){},
			onError: function(id, fileName, xhr){}
		});
	}
	function createFileUploader(){
		var uploaderfile = new qq.FileUploader({
			element: $('#file_upload')[0],
			action: 'fuploader.php',
			allowedExtensions: ['doc','docx','ppt','pptx','xls','xlsx','mdb','accdb','swf','flv','mp4','avi','mpg','zip','rar','7z','rtf','pdf','psd','mp3','wma','txt'],
			multiple: false,
			sizeLimit: 32000000,
			minSizeLimit: 0,
			debug: false,
			autoUpload:true,
			onSubmit: function(id, fileName){$('#file_upload').show();},
			onProgress: function(id, fileName, loaded, total){},
			onComplete: function(id, fileName, responseJSON){ var name=responseJSON.filename; $(".file_upload").append(getFile(name));},
			onCancel: function(id, fileName){},
			onError: function(id, fileName, xhr){}
		});
	}
	function getImage(name){
		return '<li><div class="img-container">\
						<div class="img-cell"><img src="<?php echo $Config['dir']['tmp_dir']; ?>'+name+'"></div>\
						<input type="hidden" name="images[fname][]" value="'+name+'">\
						<input class="primary-input" type="hidden" name="images[primary][]" value="0">\
						<span data-original-title="Сделать основным" data-placement="bottom" class="primary off"></span>\
						</div>\
					<div class="fieldset">\
						<span>Title</span><input type="text" name="images[title][]" value="" placeholder="Title">\
						<span>Alt</span><input type="text" name="images[alt][]" value="" placeholder="Alt">\
					</div><span class="del"><img src="img/delete.png"></span></li>';
	}
	function getFile(name){
		$('.file_upload').empty();
		return '<li><div><a target="_blank" href="<?php echo $Config['dir']['tmp_dir']; ?>'+name+'">'+name+'</a><input type="hidden" name="description[fname]" value="'+name+'"><span class="del"><img src="img/delete.png" alt=""></span></div></li>';
	}
	$(document).ready(function(){
		createImgUploader();
		<?php if($Config['section']['file']) echo "createFileUploader();\n"; ?>
		
		$('#imglist').sortable({revert:true, tolerance:'pointer'});
		
		// Images view handle
		$('#imglist li').mousedown(function(){
			$(this).css({cursor:'pointer'})	
		}).mouseup(function(){
			$(this).css({cursor:'default'})	
		});
		
		$('.del').live('click',function(){
			if(confirm('Вы действительно хотите удалить этот файл?')){
				$(this).closest('li').remove();
				$('.qq-upload-button').show();
				createUploader();
			} else return false;
		});
		
		$('.primary').live('click', function(){
			$('.primary').each(function(){
				$(this).removeClass('on').addClass('off').attr('data-original-title','Сделать основным').closest('li').find('.primary-input').val('0');
			});
			$(this).removeClass('off').addClass('on').attr('data-original-title','Основное изображение').closest('li').find('.primary-input').val('1');
			$(this).closest('li').find('.tooltip-inner').text('Основное изображение');
		});
	});
</script>
<div class="block">
	<table cellspacing="0" cellpadding="0" class="block" width="100%">
		<tr>
			<td class="text">Изображения</td>
			<td>
				<ul id='imglist' class="ui-sortable">
				<?php
					if(isset($ITEM['images']) && !empty($ITEM['images'])){
						for($i = 0, $cnt = count($ITEM['images']); $i < $cnt; $i++){
							if($ITEM['images'][$i]['primary'] == '1'){
								$_title = 'Основное изображение';
								$_class = 'on';
							} else {
								$_title = 'Сделать основным';
								$_class = 'off';
							}
							echo '<li><div class="img-container">
										<div class="img-cell"><img src="'.$Config['dir']['data_dir'].'cms_original/'.$ITEM['images'][$i]['fname'].'"></div>
										<input type="hidden" name="images[fname][]" value="'.$ITEM['images'][$i]['fname'].'">
										<input class="primary-input" type="hidden" name="images[primary][]" value="'.(int)$ITEM['images'][$i]['primary'].'">
										<span data-original-title="'.$_title.'" data-placement="bottom" class="primary '.$_class.'"></span>
									</div>
									<div class="fieldset">
										<span>Title</span><input type="text" name="images[title][]" value="'.$ITEM['images'][$i]['title'].'" placeholder="Title">
										<span>Alt</span><input type="text" name="images[alt][]" value="'.$ITEM['images'][$i]['alt'].'" placeholder="Alt">
									</div>
									<span class="del"><img src="img/delete.png"></span></li>';
							}
					}
				?>
				</ul>
				<div id='img_upload'></div>
			</td>
		</tr>
		<?php
			if($Config['section']['file']){
				echo '<tr><td class="text" >Прикрепить файл</td><td><ul class="file_upload">';
				if(isset($ITEM['fname'])&&!empty($ITEM['fname'])){
					echo'<li>
							<div>
								<a target="_blank" href="'.$Config['dir']['data_dir'].'/'.$ITEM['fname'].'">'.$ITEM['fname'].'</a>
								<input type="hidden" name="description[fname]" value="'.$ITEM['fname'].'">
								<span class="del"><img src="img/delete.png" alt=""></span>
							</div>
						</li>';
				}
				echo '</ul>	<div id="file_upload"></div></td></tr>';
			}
		?>
	</table>
</div>
