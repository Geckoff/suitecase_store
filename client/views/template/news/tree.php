<div class="page-title">
	<h1><?=$TITLE?></h1>
</div>
<div class="page-content">
	<?php
		echo $TEXT;
		for($i = 0, $cnt = count($OUTPUT); $i < $cnt; $i++){
			$OUTPUT[$i]['date'] = str_replace(array('January','February','March','April','May','June','July','August','September','October','November','December'),
											  array('Января','Февраля','Марта','Апреля','Мая','Июня','Июля','Августа','Сентября','Октября','Ноября','Декабря'),
											  date('j F Y г.', $OUTPUT[$i]['date']));
			echo '<div class="news-block">
					<a class="title" href="'.$OUTPUT[$i]['url'].'">'.$OUTPUT[$i]['title'].'</a>
					<!--<div class="date">'.$OUTPUT[$i]['date'].'</div> -->
					<div class="text">'.$OUTPUT[$i]['announcement'].'</div>
					<a style="font-weight: bold; font-size: 14px;" href="'.$OUTPUT[$i]['url'].'">Читать подробнее...</a>
				</div>';
		}
		if($COUNT_PAGES > 1){
			echo Pager($ClientConfig['HOST'].'/'.$_GET['pages'], $NPAGE, $COUNT_PAGES);
		}
	?>
</div>
