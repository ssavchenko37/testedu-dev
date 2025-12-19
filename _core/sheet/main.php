<?php
$sheet_id = $TS->request_decode('shcode',$tsreq);

$edited = true;

$sheet = $DB->selectRow('SELECT * FROM ?_3v_sheets WHERE sheet_id=?', $sheet_id);
$tutor = $TS->tutor($sheet['tutor_id'])['tutor'];
$subject = $TS->subject($sheet['subject_id']);
$group = $TS->group($sheet['grup_id']);
$titles['tutor'] = _lt([$tutor['tutor_fullru'], $tutor['tutor_fullname']]);
$titles['subject'] = _lt([$subject['subject_ru'], $subject['subject_title']]);
$titles['group'] = $group['grup_title'];
$titles['semester'] = $sheet['semester_id'];

$hasexam = ($sheet['exam_id'] === NULL) ? false: true;
$doc_title = ($hasexam) ? "Экзаменационная ведомость" : "Зачётная ведомость";

$academic_year = substr($sheet['sheet_period'], 0, -2);

$students = $DB->select('SELECT S.*'
    . ', G.grup_uin, G.grup_title'
    . ', SH.item_id, SH.sheet_id, SH.module1, SH.module2, SH.module3, SH.module4, SH.avg, SH.credit, SH.score, SH.total, SH.grade'
    . ' FROM ?_students S'
    . ' INNER JOIN ?_3v_sheets SHT ON S.grup_id=SHT.grup_id'
    . ' INNER JOIN ?_groups G ON S.grup_id=G.grup_id'
    . ' LEFT JOIN ?_3v_sheet_items SH ON S.stud_id=SH.stud_id AND SHT.sheet_id=SH.sheet_id'
    . ' WHERE SHT.sheet_id=? AND S.stud_status<>?'
    . ' ORDER BY S.stud_name, SH.item_id'
    , $sheet_id
    , 2
);
