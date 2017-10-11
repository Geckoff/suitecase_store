<?php
$tab_title = $tab_content = '';
foreach($_tabs as $infotabs){
		$idTab = translit($infotabs['title']);
		$tab_title .= '<li><a href="javascript:void(0);" tab="#'.$idTab.'">'.$infotabs['title'].'</a></li>';
		$tab_content .= '<div class="tab-pane fade" id="'.$idTab.'">'.$infotabs['content'].'</div>';
	}
echo '<div id="wrap-right">
	<form method="post" enctype="multipart/form-data" action="'.$formaction.'">
		<input type="hidden" name="description" value="" />
		<input type="hidden" name="seo" value="" />
		<input type="hidden" name="images" value="" />
		<input type="hidden" name="params" value="" />
		<ul id="infoTabs" class="nav nav-tabs">
			'.$tab_title.'
		</ul>
		<div class="tab-content">
			'.$tab_content.'
		</div>
		<input id="fsave" type="button" class="btn btn-inverse clear" name="product_save" value="Сохранить" />
	</form>
</div>';
?>
