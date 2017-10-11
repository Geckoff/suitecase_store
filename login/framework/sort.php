<?php
    /**
     * Перемещает текущую запись $id в таблице $table по направлению $direction.
     * Может содержать дополнительное условие $advansed_condition, используемое в запросе.
     * @param <'up'|'down'> $direction
     * @param <int> $id
     * @param <string> $table
     * @param <string> $advansed_condition
     */
    function DB_sort($direction,$id,$table,$advansed_condition='') {
        $Verify = DB("SELECT MIN(sort) AS min, MAX(sort) AS max, (SELECT sort FROM ".$table." WHERE id=".$id.") AS sort FROM ".$table." ".($advansed_condition!='' ? "WHERE 1=1 ".$advansed_condition : ''));
        if(!isset($Verify[0]))
            return;
        if((int)$Verify[0]['max']-(int)$Verify[0]['min'] == 0)
            return;
            
        if($direction == 'up' && (int)$Verify[0]['min'] != (int)$Verify[0]['sort']) {
            DB("SELECT @r_id:=id,@r_sort:=sort FROM ".$table." WHERE sort<".$Verify[0]['sort']." ".$advansed_condition." and `delete`='0' ORDER BY sort DESC LIMIT 1"); 
            DB("UPDATE ".$table." SET sort=@r_sort WHERE id=".$id);
            DB("UPDATE ".$table." SET sort=".$Verify[0]['sort']." WHERE id=@r_id");
        }
        if($direction == 'down' && (int)$Verify[0]['max'] != (int)$Verify[0]['sort']) {
            DB("SELECT @r_id:=id,@r_sort:=sort FROM ".$table." WHERE sort>".$Verify[0]['sort']." ".$advansed_condition." and `delete`='0' ORDER BY sort ASC LIMIT 1"); 
            DB("UPDATE ".$table." SET sort=@r_sort WHERE id=".$id);
            DB("UPDATE ".$table." SET sort=".$Verify[0]['sort']." WHERE id=@r_id");
        }
    }
?>