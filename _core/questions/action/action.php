<?php
$id = $_POST['pid'];

foreach ($_REQUEST as $rKey => $rVal) {
    if (in_array($rKey, array("question_ru","question_title","question_type"))) {
        $ins[$rKey] = trim($rVal);
    }
}

if ($_POST['mode'] == "add") {
    // $ins['subject_entered'] = date('Y-m-d');
    // $DB->query('INSERT INTO ?_3v_subjects (?#) VALUES (?a)', array_keys($ins), array_values($ins));
}
if ($_POST['mode'] == "edit") {
    $DB->query('UPDATE ?_3v_questions SET ?a WHERE question_id=?', $ins, $id);
}
if ($_POST['mode'] == "delete") {
    // $DB->query('DELETE FROM ?_3v_subjects WHERE dept_id=?', $id);
}

if ($_POST['mode'] == "upload") {
    if( count($_FILES) > 0 ) {
        $target_file = S_ROOT . DIRECTORY_SEPARATOR . S_UPLOADS . DIRECTORY_SEPARATOR . basename( $_FILES['uplfile']['name'] );
        if( move_uploaded_file($_FILES['uplfile']['tmp_name'], $target_file) ) {
            if ( file_exists( $target_file ) ) include "action-upload.php";
        }
    }
}