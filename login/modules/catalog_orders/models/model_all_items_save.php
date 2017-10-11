<?php
if (isset($P['checkbox'])){
	switch ($P['action'])
	{
		case 'Новый' : set_new($P['checkbox']); break;
		case 'Необработанный' : set_unfinished($P['checkbox']); break;
		case 'Выполненный' : set_executed($P['checkbox']); break;
		case 'Отмененный' : set_cancelled($P['checkbox']); break;
		default: break;
	}
}
?>
