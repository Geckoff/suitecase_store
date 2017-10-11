<?php
    if(isset($P['oldpass'])) {
        $R = DB("SELECT `id` FROM ".$Config['main_table']." WHERE `password` = '".md5(md5($P['oldpass']))."' LIMIT 1");
        if (isset($R[0]['id']) || md5($P['oldpass']) == ROOT_PASSWORD) {
            DB("UPDATE ".$Config['main_table']."
                SET `login` = '".md5(md5($P['login']))."',
                    `password` = '".md5(md5($P['newpass']))."'
                 WHERE `id` = 1 LIMIT 1"); 
            $_SESSION['message'] = 'Пароль успешно сохранен'; 
            $_SESSION['login'] = $P['login'];
            $_SESSION['password'] = $P['newpass'];
        }
        else {
            $_SESSION['error'] = 'Вы неверно ввели старый пароль';
        }
    }
?>