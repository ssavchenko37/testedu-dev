<?php
$shcode = $TS->request_decode('shcode',$tsreq);

$sheet = $DB->selectRow('SELECT * FROM ?_3v_sheets WHERE sheet_id=?', $shcode);
$tutor = $TS->tutor($sheet['tutor_id'])['tutor'];
$subject = $TS->subject($sheet['subject_id']);
p($tutor);
// p($sheet);
// p($tutor);
// p($tutor['tutor']['tutor_fullname']);
// p($tutor['tutor']['tutor_fullru']);
// p($tutor['tutor']['assistant']);

// $subject['subject_title']
// $subject['subject_ru']

$s_credits = ($subject['subject_credits'] < 4) ? $subject['subject_credits']: 4;
$s_credits = floor($s_credits);