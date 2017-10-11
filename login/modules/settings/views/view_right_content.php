<?php
    if(isset($settings) && count($settings) > 0) { 
        $hide = ''; 
    }
    else {
        $hide = 'hide';
    }
?>
<div class="<?php echo $hide; ?>" id="wrap-right">
    <form>
    		<div class="block-header">Список текущих настроек</div>
    		<div class="block">
    			<table cellspacing="0" cellpadding="0" class="block" width="600px">
    			<?php
                    $count = count($settings);
                    if ($count > 1) {
                        $stl = 'style="border-bottom: 1px solid #bbb;"';
                    }
                    else {
                        $stl = '';
                    }
                    $html = '';
                    for($i = 0; $i < $count; $i++){
                        
                    	$html.=' <tr '.$stl.'>
                    				<td class="td-text td-text-head">'.$settings[$i]['value'].':</td>
                    				<td class="td-text">'.$settings[$i]['se_name'].'</td>
                    				<td class="td-text">'.$settings[$i]['se_value'].'</td>
                    			</tr>';
                    }
                    echo $html;
    			?>
    			</table>
    		</div>
    		<div style="clear:both;"></div>
    
    	<input type="hidden" name="id" value="<?php if (isset($G['id'])) print $G['id']; ?>" />
    	<input type="hidden" name="parent" value="<?php if (isset($G['parent'])) print $G['parent']; ?>" />
    </form>
</div>