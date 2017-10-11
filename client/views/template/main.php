<?php
	$SLIDER = getListSlidesByParent($ClientConfig['slider']);
	if(count($SLIDER) > 0){
		echo '<div class="slider-wrapper theme-default"><div id="slider" class="nivoSlider">';
		for($i = 0, $cnt = count($SLIDER); $i < $cnt; $i++){
			echo '<a href="'.$SLIDER[$i]['url'].'"><img src="'.$ClientConfig['DATA_URL'].'/slider/original/'.$SLIDER[$i]['image'].'" /></a>';
		}
		echo '</div></div>';
	}
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
	$OUTPUT = getCatalogTree($ClientConfig['catalog_root'], $_catalog_url, $ClientConfig['catalog_root'], 0, 6, "order by  `".$TABLE['catalog_item']."`.`featured` desc, `".$TABLE['catalog_tree']."`.`id_tree` asc, `".$TABLE['catalog_tree']."`.`sort` asc, `".$TABLE['catalog_item']."`.`id_tree` asc, `".$TABLE['catalog_item']."`.`sort` asc");
	for($i = 0, $cnt = count($OUTPUT); $i < $cnt; $i++){
		$_cl = $dsBuf = $prBuf = '';
		if($i % 3 == 0) $_cl = 'class="first"';
		if($OUTPUT[$i]['discount'] == 1 && $OUTPUT[$i]['price'] != 0){
			$dsv = round(100 - ($OUTPUT[$i]['ds_price']/$OUTPUT[$i]['price'])*100);
			$dsBuf = '<span class="discount" title="Скидка '.$dsv.'%">-'.$dsv.'%</span>';
			$oldPriceBuf ='<span class="old-price"><strike>'.number_format($OUTPUT[$i]['price'],0,"."," ").' руб</strike></span>';
		}else{
			$oldPriceBuf = '<span>&nbsp;</span>';
		}
		if($OUTPUT[$i]['ds_price'] != 0) $prBuf = '<span class="price">'.number_format($OUTPUT[$i]['ds_price'],0,"."," ").' руб</span>'; else $prBuf = '<span>Уточняйте стоимость</span>';
		if($OUTPUT[$i]['available'] == 0) $_btnClass = 'disabled'; else $_btnClass = 'add-to-cart';
        $preden_price = $OUTPUT[$i]['ds_price'] * 10000;
        $preden_price = '<span class="preden-price">'.number_format($preden_price,0,"."," ").' руб</span>';
		echo '<li '.$_cl.'>
				<a class="product-img" href="'.$OUTPUT[$i]['url'].'" title="'.$OUTPUT[$i]['title'].'">
					'.$dsBuf.'
					<div>
						<img src="'.$ClientConfig['DATA_URL'].'/catalog/medium/'.$OUTPUT[$i]['img'][0]['fname'].'" alt="'.$OUTPUT[$i]['img'][0]['alt'].'"/>
					</div>
				</a>
				<div class="product-description">
					<a class="title" href="'.$OUTPUT[$i]['url'].'" title="'.$OUTPUT[$i]['title'].'">'.$OUTPUT[$i]['title'].'</a>
				<!--	<a class="description" href="'.$OUTPUT[$i]['url'].'">'.$OUTPUT[$i]['description'].'</a> -->
				</div>
				<div class="product-info">
					'.$prBuf.'
                    '.$preden_price.'
					'.$oldPriceBuf.'
					<a class="more btn" href="'.$OUTPUT[$i]['url'].'" title="Подробнее о '.$OUTPUT[$i]['title'].'">Подробнее</a>
					<a class="'.$_btnClass.' btn btn-red" href="#" title="Купить" data-product-id="'.$OUTPUT[$i]['id'].'" onclick="yaCounter24243322.reachGoal(\'buybut\'); return true;">Купить&nbsp;&nbsp;<span class="add"></span></a>
				</div>
			</li>';
	}
?>
</ul>
<div class="page-content">
	<?=$TEXT_PART[1]?>
</div>
