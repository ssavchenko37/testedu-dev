<?php
$loc = "";
$Adm = $Tch = $Std = array();
if (isset($_POST['login_mode']) == "login") {
    if (!empty($_POST['your_email']) && !empty($_POST['your_pass'])) {
        $Adm = $DB->selectRow('SELECT * FROM ?_adm WHERE login=? AND hide=?', trim($_POST['your_email']), 0);
        if (($Adm['pass'] ?? '') == $_POST['your_pass']) {
            $adm_opt = $DB->selectRow('SELECT * FROM ?_adm_lvl WHERE id=?', $Adm['lvl']);
            $set_cookie['period'] = $period['uin'];
            $set_cookie['umod'] = 'a';
            $set_cookie['id'] = $Adm['id'];
            $str_cookie = code2cook($set_cookie);
            $loc = "iadm";
        }
    
        if (empty($loc)) {
            $Tch = $DB->selectRow('SELECT * FROM ?_tutor WHERE (tutor_uin=? OR tutor_email=?) AND hide=?', trim($_POST['your_email']), trim($_POST['your_email']), 0);
            if (($Tch['tutor_pass'] ?? '') == $_POST['your_pass']) {
                $set_cookie['period'] = $period['uin'];
                $set_cookie['umod'] = 't';
                $set_cookie['id'] = $Tch['tutor_id'];
                $str_cookie = code2cook($set_cookie);
                $loc = "itch";
            }
        }

        if (empty($loc)) {
            $Std = $DB->selectRow('SELECT * FROM ?_students WHERE (stud_uin=? OR stud_email=?) AND stud_status<?', trim($_POST['your_email']), trim($_POST['your_email']), 2);
            if (($Std['stud_pass'] ?? '') == $_POST['your_pass']) {
                $set_cookie['umod'] = 's';
                $set_cookie['id'] = $Std['stud_id'];
                $str_cookie = code2cook($set_cookie);
                $loc = "istd";
            }
        }
    }
}

if (!empty($str_cookie)) {
    if ($_POST['remember_me']) {
        setcookie ("ts_sys", $str_cookie, time() + EXPIRY, "/");
        setCookie('ts_exp', time(), time() + EXPIRY);
    } else {
        setcookie ("ts_sys", $str_cookie, 0, "/");
    }
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: /");
}
