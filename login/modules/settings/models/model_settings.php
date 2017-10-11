<?php
    $settings = DB("SELECT
					`S`.`id`,`S`.`value`,`S`.`description`,
					`SE`.`value` AS `se_value`, `SE`.`name` AS `se_name`
					FROM `".$Config['settings']."` AS `S`
					INNER JOIN `".$Config['settings_element']."` AS `SE`
					ON `S`.`id`=`SE`.`id_setting`
					WHERE `S`.`delete`=0 AND `SE`.`delete`=0 ORDER BY `SE`.`sort` ASC
				");
?>