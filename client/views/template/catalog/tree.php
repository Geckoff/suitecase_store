<?php

	$text_arr = array('товар', 'товара', 'товаров');

	$text = $text_arr[PluralType($TOTAL_COUNT)];

	$tc = '<span><strong>'.$TOTAL_COUNT.'</strong>&nbsp;'.$text.'</span>';

    $TEXT_PART = explode ("<hr />", $TEXT, 2);
    
    $GET_H1 = DB("select `".$TABLE['catalog_tree']."`.`h1` FROM `".$TABLE['catalog_tree']."`
				where `".$TABLE['catalog_tree']."`.`title` = '".$TITLE."' and `".$TABLE['catalog_tree']."`.`active` = '1' and `".$TABLE['catalog_tree']."`.`delete` = '0'
				order by `".$TABLE['catalog_tree']."`.`sort` LIMIT 1");
?>

<div class="page-title">

	<h1><?php if(isset($GET_H1[0]['h1']) && !empty($GET_H1[0]['h1'])) echo $GET_H1[0]['h1']; else echo $TITLE; ?></h1>

</div>

<div class="page-content">
	<?php
        if (!isset($_GET['npage'])) {
            echo $TEXT_PART[0];    
        }
    ?>
</div>

<div class="catalog-items">

	<div class="toolbar">

		<div class="pager clearfix">

			<span class="amount"><?php echo $tc; ?></span>

			<div class="sort-by">

				<label>Сортировать по</label>

				<select onchange="setLocation(this.value)">

					<option value="<?php echo $CURRENT.'&orderby=sort_asc';?>" sort="sort_asc">По умолчанию</option>

					<option value="<?php echo $CURRENT.'&orderby=price_asc';?>" sort="price_asc">Цена: по возрастанию</option>

					<option value="<?php echo $CURRENT.'&orderby=price_desc';?>" sort="price_desc">Цена: по убыванию</option>

					<option value="<?php echo $CURRENT.'&orderby=title_asc';?>" sort="title_asc">Название: от А до Я</option>

					<option value="<?php echo $CURRENT.'&orderby=title_desc';?>" sort="title_desc">Название: от Я до А</option>

				</select>

			</div>

		</div>		

	</div>

	<ul id="products" class="product-list clearfix">

	<?php

		for($i = 0, $cnt = count($OUTPUT); $i < $cnt; $i++){

			$_cl = $dsBuf = $prBuf = '';

			if($i % 3 == 0) $_cl = 'class="first"';

			if($OUTPUT[$i]['discount'] == 1 && $OUTPUT[$i]['price'] != 0){

				$dsv = ceil(100 - ($OUTPUT[$i]['ds_price']/$OUTPUT[$i]['price'])*100);

				$dsBuf = '<span class="discount" title="Скидка '.$dsv.'%">-'.$dsv.'%</span>';

				$oldPriceBuf ='<span class="old-price"><strike>'.number_format($OUTPUT[$i]['price'],0,"."," ").' руб</strike></span>';

			}else{

				$oldPriceBuf = '<span>&nbsp;</span>';

			}

			if($OUTPUT[$i]['ds_price'] != 0) $prBuf = '<span class="price">'.number_format($OUTPUT[$i]['ds_price'],0,"."," ").' руб</span>'; else $prBuf = '<span>Уточняйте стоимость</span>';

			if($OUTPUT[$i]['available'] == 0) $_btnClass = 'disabled'; else $_btnClass = 'add-to-cart';


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

						'.$oldPriceBuf.'

						<a class="more btn" href="'.$OUTPUT[$i]['url'].'" title="Подробнее о '.$OUTPUT[$i]['title'].'">Подробнее</a>

						<a class="'.$_btnClass.' btn btn-red" href="#" title="Купить" data-product-id="'.$OUTPUT[$i]['id'].'" onclick="yaCounter24243322.reachGoal(\'buybut\'); return true;">Купить&nbsp;&nbsp;<span class="add"></span></a>

					</div>

				</li>';

		}

	?>

	</ul>

	<div class="toolbar">

		<div class="pager clearfix">

			<?php

				if($COUNT_PAGES > 1){

					if(isset($_GET['q']) && !empty($_GET['q'])){

						echo Pager($ClientConfig['HOST'].'/'.$_GET['pages'], $NPAGE, $COUNT_PAGES, '?q='.$_GET['q']);

					} else {

						echo Pager($ClientConfig['HOST'].'/'.$_GET['pages'], $NPAGE, $COUNT_PAGES);

					}

				} else echo '<span class="amount">'.$tc.'</span>';

			?>

			<div class="sort-by">

				<label>Сортировать по</label>

				<select onchange="setLocation(this.value)">

					<option value="<?php echo $CURRENT.'&orderby=sort_asc';?>" sort="sort_asc">По умолчанию</option>

					<option value="<?php echo $CURRENT.'&orderby=price_asc';?>" sort="price_asc">Цена: по возрастанию</option>

					<option value="<?php echo $CURRENT.'&orderby=price_desc';?>" sort="price_desc">Цена: по убыванию</option>

					<option value="<?php echo $CURRENT.'&orderby=title_asc';?>" sort="title_asc">Название: от А до Я</option>

					<option value="<?php echo $CURRENT.'&orderby=title_desc';?>" sort="title_desc">Название: от Я до А</option>

				</select>

			</div>

		</div>			

	</div>

</div>

<div class="page-content">
	<?php
        if (!isset($_GET['npage'])) {
            echo $TEXT_PART[1];    
        }
    ?>
</div>
