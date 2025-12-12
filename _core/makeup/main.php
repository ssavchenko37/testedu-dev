<?php
$ibcode = $TS->request_decode('ibcode',$tsreq);

$unit_scores = array("score_atten"=>"SIW","score_curr"=>"Curr. score","score_contr"=>"Contr. score","total"=>"Total");

$MAXDays = 46;

$ibook = $DB->selectRow('SELECT IB.*'
    . ', T.tutor_fullru, T.tutor_fullname'
    . ', GR.grup_title'
    . ', CONCAT(S.subject_code, " / ", S.subject_title) AS title_en'
    . ', CONCAT(S.subject_code, " / ", S.subject_ru) AS title_ru'
    . ', CONCAT(S.subject_code, " / ", S.subject_kg) AS title_kg'
    . ' FROM ?_ibook IB'
    . ' INNER JOIN ?_tutor T ON IB.tutor_id=T.tutor_id'
    . ' INNER JOIN ?_groups GR ON IB.grup_id=GR.grup_id'
    . ' INNER JOIN ?_3v_subjects S ON IB.subject_id=S.subject_id'
    . ' WHERE ibook_id=?'
    , $ibcode
);
$ibook_id = $ibook['ibook_id'];

$year = ceil($ibook['semester_id']/2);

$students = $DB->select('SELECT * FROM ?_students WHERE grup_id=? AND stud_status<? ORDER BY stud_id', $ibook['grup_id'], 2);


$meta = $DB->select('SELECT meta_uin AS ARRAY_KEY, meta_id, ibook_id, meta_date, DATE_FORMAT(meta_date, "%m-%d ") AS tdate, meta_topic, meta_class, meta_hours'
    . ' FROM ?_ibook_meta'
    . ' WHERE ibook_id=?'
    , $ibook_id
);

$items = array();
$tmp_items = $DB->select('SELECT *'
    . ' FROM ?_ibook_items'
    . ' WHERE ibook_id=?'
    , $ibook_id
);

foreach ($tmp_items as $iv) {
    $items[$iv['item_uin']][$iv['stud_id']] = $iv;
}
