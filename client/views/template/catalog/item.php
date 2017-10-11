<?php

	include_once dirname(__FILE__)."/../../../models/functions/catalog.php";

	$dsBuf = $spBuf = $avBuf = $prBuf = '';

	if($OUTPUT['discount'] == 1 && $OUTPUT['price'] != 0){

		$dsv = round(100 - ($OUTPUT['ds_price']/$OUTPUT['price'])*100);

		#$dsBuf = '<div class="tag"><span class="tag-left"></span><span class="tag-body">Скидка '.$dsv.'%</span><span class="tag-right"></span></div>';

		$dsBuf = '<span class="discount" title="Скидка '.$dsv.'%">-'.$dsv.'%</span>';

		$oldPriceBuf ='<span class="old-price"><strike>'.number_format($OUTPUT['price'],0,"."," ").' руб</strike></span>';

	}else{

		$oldPriceBuf = '<span>&nbsp;</span>';

	}

	if($OUTPUT['special'] == 1) $spBuf = '<div class="tag"><span class="tag-left"></span><span class="tag-body">Спецпредложение</span><span class="tag-right"></span></div>';

	if($OUTPUT['available'] == 0){

		$avBuf = '<div class="tag"><span class="tag-left"></span><span class="tag-body">Нет в наличии</span><span class="tag-right"></span></div>';

		$_btnClass = 'disabled';

	}else {

		$_btnClass = 'add-to-cart';

	}

	if($OUTPUT['ds_price'] != 0) $prBuf = '<span class="price">'.number_format($OUTPUT['ds_price'],0,"."," ").' руб</span>'; else $prBuf = '<span>Уточняйте стоимость</span>';

	$SIMILAR = DB("SELECT `id`,`id_tree`,`title`,`url`,`description`,`price`,`available`,`discount`,`ds_price` FROM `".$TABLE['catalog_item']."` WHERE `id_tree` = '".$OUTPUT['id_tree']."' AND `id` != '".$OUTPUT['id']."' AND `active` = '1' AND `delete` = '0' ORDER BY `".$TABLE['catalog_item']."`.`sort` ASC LIMIT 0, 6");

	for($i = 0, $cnt = count($SIMILAR); $i < $cnt; ++$i){

		if(strlen($SIMILAR[$i]['description']) > 250){

			$SIMILAR[$i]['description'] = TruncateWords(strip_tags($SIMILAR[$i]['description']), 250).'...';

		}

		$img = DB("SELECT `title`, `alt`, `fname` FROM `".$TABLE['catalog_img']."` WHERE `id_item` = '".$SIMILAR[$i]['id']."' ORDER BY `primary` DESC, `sort` ASC LIMIT 0, 1");

		if(!isset($img[0]['fname']) || empty($img[0]['fname'])){

			$SIMILAR[$i]['img'][0]['title'] = 'Нет изображения';

			$SIMILAR[$i]['img'][0]['alt'] = 'Нет изображения';

			$SIMILAR[$i]['img'][0]['fname'] = 'no-photo.jpg';

		}else {

			$SIMILAR[$i]['img'][0]['title'] = $img[0]['title'];

			$SIMILAR[$i]['img'][0]['alt'] = $img[0]['alt'];

			$SIMILAR[$i]['img'][0]['fname'] = $img[0]['fname'];

		}

		$category = getUrlTree($TABLE['catalog_tree'], $SIMILAR[$i]['id_tree'], $ClientConfig['catalog_root']);

		$category[]['url'] = $_catalog_url;

		$tmp_cat = '';

		for($cntCat = count($category), $j = $cntCat -1; $j >= 0; $j--){

			$tmp_cat .= $category[$j]['url'].'/';

		}

		$SIMILAR[$i]['url'] = $tmp_cat.$SIMILAR[$i]['url'];

	}

?>

<div class="cols clearfix">

	<?php

		if(count($OUTPUT['img']) > 0 && $OUTPUT['img'][0]['fname'] != 'no-photo.jpg'){

			echo '<div class="image-block">

					<div class="image-container targetarea">

						<img id="zoomer" src="'.$ClientConfig['DATA_URL'].'/catalog/large/'.$OUTPUT['img'][0]['fname'].'" alt=""/>

					</div>';

			if(count($OUTPUT['img']) > 1){

				echo '<div class="scroller">';

                

                if(count($OUTPUT['img']) > 7) { 

                    echo '<a href="" id="prev">Prev</a>';

                    $styleNoPrev = ''; 

                }

                else {

                    $styleNoPrev = 'style="margin: 0"';

                }

                

                echo '<div id="thumbs_list" ',$styleNoPrev,'><ul class="zoomer thumbs">';

				for($i = 0, $cnt = count($OUTPUT['img']); $i < $cnt; $i++){

					echo '<li><a href="'.$ClientConfig['DATA_URL'].'/catalog/large/'.$OUTPUT['img'][$i]['fname'].'" data-large="'.$ClientConfig['DATA_URL'].'/catalog/cms_original/'.$OUTPUT['img'][$i]['fname'].'"><img src="'.$ClientConfig['DATA_URL'].'/catalog/small/'.$OUTPUT['img'][$i]['fname'].'" /></a></li>';

				}

                echo '</ul></div>';

				if(count($OUTPUT['img']) > 7) { echo '<a href="" id="next">Next</a>'; }

                echo '</div>';

			}	

			echo '</div>';

		}else {

			echo '<div class="image-block">

					<div class="image-container targetarea">

						<img src="'.$ClientConfig['DATA_URL'].'/catalog/large/'.$OUTPUT['img'][0]['fname'].'" alt=""/>

					</div></div>';

		}

	?>

	<div class="info-block">

		<h1><?=$OUTPUT['title']?></h1>

		<div class="buy-block clearfix">

			<div class="prices">

				<?=$prBuf?>

				<?=$oldPriceBuf?>

			</div>

			<?=$dsBuf?>

			<a class="<?=$_btnClass?> btn btn-red" href="#" title="Купить" data-product-id="<?=$OUTPUT['id']?>" onclick="yaCounter24243322.reachGoal('buybut'); return true;">Купить<span class="add"></span></a>

		</div>

		<?php

			/*

			if($dsBuf != '' || $spBuf != '' || $avBuf != ''){

				echo '<div class="tags clearfix">'.$dsBuf.$spBuf.$avBuf.'</div>';

			}

			*/

		?>

		<div class="short-desc clearfix">

			<?php

				$OUTPUT['show_short'] = 0;

				if($OUTPUT['show_short'] == 1){

					echo $OUTPUT['short_description'].'<a class="more" href="'.$ClientConfig['HOST'].'/'.$_GET['pages'].'#description" data-tab="description">Показать полностью</a>';

				}else {

					echo $OUTPUT['description'];

				}

			?>

		</div>

	</div>

</div>

<noindex><div class="item-delivery-note"><font color="#FFFF33"><b>ВНИМАНИЕ! ATTENTION&nbsp;PLEASE!:)</b></font> Уважаемый покупатель! Если Вы насмотрели какой-либо товар, пожалуйста, постарайтесь не откладывать оформление заказа. Лучше заказать заранее (за 3-4-5 дней, в идеале - за неделю:)), <font color="#FFFF33"><b>даже (обратите внимание!) если Вы находитесь в столице</b></font>. Иногда это связано с наличием товара на складе (если Вам очень надо, то за 2-3 дня поторопим поставщиков), а также со сроком доставки в регионы (может занимать те же 2-3 дня). Звоните, пишите, оформляйте заказы - мы всегда Вам рады! <font color="#FFFF33"><b>Спасибо, что Вы с нами!;)</b></font></div><noindex>

<div class="pluso" data-background="transparent" data-options="small,square,line,horizontal,counter,theme=08" data-services="vkontakte,odnoklassniki,facebook,twitter"></div>



<div class="tabs clearfix">

	<ul class="tab-nav">

		<?php

			if($OUTPUT['show_short'] == 1) echo '<li><a href="'.$ClientConfig['HOST'].'/'.$_GET['pages'].'#description" name="description" data-tab="#description">Описание</a></li>';

			if(count($OUTPUT['params']) > 0) echo '<li><a href="'.$ClientConfig['HOST'].'/'.$_GET['pages'].'#options" data-tab="#options">Параметры</a></li>';

			if(count($SIMILAR) > 0) echo '<li><a href="'.$ClientConfig['HOST'].'/'.$_GET['pages'].'#similar" data-tab="#similar">Похожие товары</a></li>';

		?>

	</ul>

	<div class="tab-content">

		<div id="description">

			<?php

				if($OUTPUT['show_short'] == 1){

					echo $OUTPUT['description'];

				}

			?>

		</div>

		<div id="options">

			<ul class="params clearfix">

			<?php

				for($i = 0, $cnt = count($OUTPUT['params']); $i < $cnt; $i++){

					if($i == 0) $_cl = 'class="expand"'; else $_cl = '';

					echo '<li '.$_cl.'><a href="#">'.$OUTPUT['params'][$i]['name'].'</a><ul>';

					for($j = 0, $c = count($OUTPUT['params'][$i]['parameters']); $j < $c; $j++){

						echo '<li><span class="p-title">'.$OUTPUT['params'][$i]['parameters'][$j]['name'].'</span><span class="p-value">'.$OUTPUT['params'][$i]['parameters'][$j]['value'].'</span></li>';

					}

					echo '</ul></li>';

				}

			?>

			</ul>

		</div>

		<div id="similar">

			<ul class="similar clearfix">

			<?php

				for($i = 0, $cnt = count($SIMILAR); $i < $cnt; $i++){

					$prBuf = '';

					if($SIMILAR[$i]['discount'] == 1 && $SIMILAR[$i]['price'] != 0){

						$oldPriceBuf ='<span class="old-price"><strike>'.number_format($SIMILAR[$i]['price'],0,"."," ").'&nbsp;руб.</strike></span>';

					}else{

						$oldPriceBuf = '<span>&nbsp;</span>';

					}

					if($SIMILAR[$i]['ds_price'] != 0) $prBuf = '<span class="price">'.number_format($SIMILAR[$i]['ds_price'],0,"."," ").' руб</span>'; else $prBuf = '<span>Уточняйте стоимость</span>';

					if($SIMILAR[$i]['available'] == 0) $_btnClass = 'disabled'; else $_btnClass = 'add-to-cart';

					echo '<li>

							<a class="product-img" href="'.$SIMILAR[$i]['url'].'" title="'.$SIMILAR[$i]['title'].'">

								<div>

									<img src="'.$ClientConfig['DATA_URL'].'/catalog/small/'.$SIMILAR[$i]['img'][0]['fname'].'" alt="'.$SIMILAR[$i]['img'][0]['alt'].'" />

								</div>

							</a>

							<div class="product-description">

								<a class="title" href="'.$SIMILAR[$i]['url'].'">'.$SIMILAR[$i]['title'].'</a>

								<a class="description" href="'.$SIMILAR[$i]['url'].'">'.$SIMILAR[$i]['description'].'</a>

							</div>

							<div class="product-info">

								'.$prBuf.'

								'.$oldPriceBuf.'

								<a class="'.$_btnClass.' btn btn-red" href="#" title="Купить" data-product-id="'.$SIMILAR[$i]['id'].'" onclick="yaCounter24243322.reachGoal(\'buybut\'); return true;">Купить<span class="add"></span></a>

							</div>

						</li>';

				}

			?>

			</ul>

		</div>

	</div>

</div>

<div class="vendor">
    <?php if (strpos(strtolower($OUTPUT['title']), 'cagia')):?>
        <p>Производитель: УП "Каджия", Минск, улица Олега Кошевого, 18, комн 1</p>
    <?php elseif (strpos(strtolower($OUTPUT['title']), 'larsen')):?>
        <p>Производитель: ЧПУП "Рекламная Группа Альтернатива", г. Могилев, ул. Орловского, 2</p>
    <?php elseif (strpos(strtolower($OUTPUT['title']), 'polar')):?>
        <p>Производитель: ООО "Полар Центр", г. Москва, ул. Зорге, 9</p>
    <?php else: ?>
        <p>Производитель: ООО "Фортуна", г. Москва, ул. Борисовские Пруды, д.16, к.5</p>  
    <?php  endif; ?>
</div>

