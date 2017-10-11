<style type="text/css">
    #input {
        width: 200px;
    }
    #select {
        height: 20px;
        width: 200px;
    }
    #inputs-block {
        margin: 0;
        float: left;
    }
    #right_center_blok #inputs-block input,
    #right_center_blok #inputs-block select {
        width: 180px;
        margin: 0 10px 0 0;
    }
    #delete {
        float: left;
    }
    
    #hidden *{
        visibility: hidden;
        position: absolute;
    }
    #save{
        margin-left: 225px;
        width: 100px;
    }
    #wrap-right #add_menu_element_ {
        color: #111;
    }
</style>
<script type="text/javascript">
    $(function(){
        $('#add_menu_element_').live('click', function(){
            $('.block, .block-header').removeClass('hide');
            $('#elements_table').append($('#hidden').html());
        });
        $('.jq-delete').live('click', function(){
            $(this).closest('tr').remove();
            return false;    
        });    
    });
</script>

<div id="wrap-right">

    <form action="<?php echo $URL,'&action=add_elements&id='.$G['id'];?>" method="POST">
    
        <?php
            if(isset($menu_elements) && count($menu_elements) > 0) { 
                $hide = ''; 
            }
            else {
                $hide = 'hide';
            }
        ?>
        <div class="block-header <?php echo $hide; ?>">Список элементов в меню</div>
        <div class="block <?php echo $hide; ?>">
            <table class="struct-table" id="elements_table">
                <?php
                if(isset($menu_elements))
                    foreach($menu_elements as $element) {
                ?>
                <tr>
                    <td class="even">
                        <div id="inputs-block">
                            <input name="menu_name[]" id="input" type="text" value="<?php echo htmlspecialchars($element['title']);?>" placeholder="Введите название" />
                            <select name="id_from_struct[]" id="select">
                                <?php
                                foreach($pages_from_struct as $page){
                                    $selected = '';
                                    if ($element['id_page'] == $page['id']){
                                        $selected = 'selected';
                                    }
                                    echo '<option '.$selected.' value='.$page['id'].'>'.$page['menu_title'].'</option>';
                                }
                                ?>
                            </select>
                            <input name="menu_url[]" id="input" type="text" value="<?php echo $element['url'];?>" placeholder="или ссылку на страницу" />
                        </div>
                        <div class="delete" id="delete">
                            <a href="<?php echo $URL,'&action=delete_element&id='.$element['id'].'&menu_id='.$G['id']; ?>" onclick="return confirm('Вы действительно желаете удалить данный элемент меню?')">
                                <img src="img/delete.png" alt="✖" onclick="return confirm(\'Вы действительно хотите удалить?\');" />
                            </a>
                        </div>
                    </td>
                </tr>
                <?php }?>
            </table>
        </div>
        <input id="add_menu_element_" class="btn" type="button" value="+ добавить элемент в меню" />
        <input class="btn btn-inverse clear" type="submit" value="Сохранить" />
    </form>

    <table id="hidden">
        <tr>
            <tr>
                <td class="even">
                    <div id="inputs-block">
                        <input name="menu_name[]" id="input" type="text" placeholder="Введите название" />
                        <select name="id_from_struct[]" id="select">
                              <?php
                                  foreach($pages_from_struct as $page)  {
                                    echo '<option value='.$page['id'].'>'.$page['menu_title'].'</option>';
                                  }
                              ?>
                        </select>
                        <input name="menu_url[]" id="input" type="text" placeholder="или ссылку на страницу" />
                    </div>
                    <div class="delete" id="delete">
                        <a class="jq-delete" href="<?php echo $URL,'&action=delete_element&id='.$element['id'].'&menu_id='.$G['id']; ?>" onclick="return confirm('Удалить элемент меню?')">
                            <img src="img/delete.png" alt="✖" onclick="return confirm(\'Вы действительно хотите удалить?\');" />
                        </a>
                    </div>
                </td>
            </tr>
        </tr>
    </table>
</div>
