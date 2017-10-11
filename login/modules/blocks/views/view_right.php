<div id="wrap-right">
    <form method="POST" action="<?php echo $URL,'&action=blocks_save'; ?>" enctype="multipart/form-data">
        <div class="block-header">Основные настройки</div>
        <div class="block">
            <table cellspacing="0" cellpadding="0" class="block" width="100%">
                <tr>
                    <td class="meta-text">Название блока</td>
                    <td>
                        <input type="text" id="meta_title" class="meta_title" name="name" value="<?php if (isset($_BLOCKS[0]['name'])) echo htmlspecialchars($_BLOCKS[0]['name']); ?>" />
                    </td>
                </tr>
            </table>
        </div>
        <div class="block-header">Текст блока</div>
        <div class="block">
            <table cellspacing="0" cellpadding="0" class="block" width="100%">
                <tr>
                    <td class="meta-text">Информация</td>
                    <td>
                        <textarea id="tmce1" cols="80" rows="10" name="content"><?php if (isset($_BLOCKS[0]['content'])) echo $_BLOCKS[0]['content']; ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <?php
            if (isset($G['id'])) {
                echo '<input type="hidden" name="id" value="'.$G['id'].'"/>';
            }
        ?>
        <input class="btn btn-inverse" type="submit" name="submit" value="Сохранить" />
    </form>
</div>
<script type="text/javascript">
    $(function(){
        $('img.news_active_img').live('click',function(){ //чекбоксы
            if($(this).next('input').val() == '1') {
                $(this).attr('src','img/struct-content-check.png');
                $(this).next('input').val('0');
            }
            else {
                $(this).attr('src','img/struct-content-check-active.png');
                $(this).next('input').val('1');
            }
        });
    });
</script>