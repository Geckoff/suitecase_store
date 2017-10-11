<?php
    $TEXT_PART = explode ("<hr />", $TEXT, 2);
?>
<div class="page-title">
	<h1><?=$TITLE?></h1>
</div>
<div class="page-content">
	<?=$TEXT_PART[0]?>
</div>
<ul class="product-list grid clearfix">
<?php
	for($i = 0, $cnt = count($OUTPUT); $i < $cnt; $i++){
		$_cl = $dsBuf = $spBuf = $avBuf =  '';
		if($i % 3 == 0) $_cl = 'class="first"';
		echo '<li '.$_cl.'>
				<a class="product-img" href="'.$OUTPUT[$i]['url'].'" title="'.$OUTPUT[$i]['title'].'">
					<div>
						<img src="'.$ClientConfig['DATA_URL'].'/catalog/medium/'.$OUTPUT[$i]['img'][0]['fname'].'" alt=""/>
					</div>
				</a>
				<div class="product-description">
					<a class="title" href="'.$OUTPUT[$i]['url'].'" title="'.$OUTPUT[$i]['title'].'">'.$OUTPUT[$i]['title'].'</a>
					<a class="description" href="'.$OUTPUT[$i]['url'].'">'.$OUTPUT[$i]['description'].'</a>
				</div>
			</li>';
	}
	echo '</ul>';
	if($COUNT_PAGES > 1){
		if(isset($_GET['q']) && !empty($_GET['q'])){
			echo Pager($ClientConfig['HOST'].'/'.$_GET['pages'], $NPAGE, $COUNT_PAGES, '?q='.$_GET['q']);
		} else {
			echo Pager($ClientConfig['HOST'].'/'.$_GET['pages'], $NPAGE, $COUNT_PAGES);
		}
	}
?>
<div class="page-content">
	<?=$TEXT_PART[1]?>
</div>