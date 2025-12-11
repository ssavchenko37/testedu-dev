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
$sids = $DB->selectCol('SELECT stud_id FROM ?_students WHERE grup_id=? ORDER BY stud_id', $ibook['grup_id']);

$other_items = $DB->selectCol('SELECT I.item_id'
    . ' FROM ?_ibook B'
    . ' INNER JOIN ?_ibook_items I ON B.ibook_id=I.ibook_id'
    . ' WHERE I.ibook_id<>? AND B.sheet_period=? AND B.subject_id=? AND B.ibook_type=? AND I.stud_id IN(?a)'
    , $id, $ibook['sheet_period'], $ibook['subject_id'], $ibook['ibook_type'], $sids
);
$other_units = $DB->selectCol('SELECT U.unit_id'
    . ' FROM ?_ibook B'
    . ' INNER JOIN ?_ibook_units U ON B.ibook_id=U.ibook_id'
    . ' WHERE U.ibook_id<>? AND B.sheet_period=? AND B.subject_id=? AND B.ibook_type=? AND U.stud_id IN(?a)'
    , $id, $ibook['sheet_period'], $ibook['subject_id'], $ibook['ibook_type'], $sids
);

if (count($other_items) > 0) {
    foreach ($other_items as $r) {
        $upd['ibook_id'] = $ibook_id;
        $DB->query('UPDATE ?_ibook_items SET ?a WHERE item_id=?', $upd, $r);
    }
}
if (count($other_units) > 0) {
    foreach ($other_units as $r) {
        $upd['ibook_id'] = $ibook_id;
        $DB->query('UPDATE ?_ibook_units SET ?a WHERE unit_id=?', $upd, $r);
    }
}

$meta = $DB->select('SELECT meta_uin AS ARRAY_KEY, meta_id, ibook_id, meta_date, DATE_FORMAT(meta_date, "%m-%d ") AS tdate, meta_topic, meta_class, meta_hours'
    . ' FROM ?_ibook_meta'
    . ' WHERE ibook_id=?'
    , $ibook_id
);

$items = $units = array();
$tmp_items = $DB->select('SELECT *'
    . ' FROM ?_ibook_items'
    . ' WHERE ibook_id=?'
    , $ibook_id
);

foreach ($tmp_items as $iv) {
    $items[$iv['item_uin']][$iv['stud_id']] = $iv;
}

if ($ibook['ibook_type'] == "pr") {
    $tmp_units = $DB->select('SELECT *'
        . ' FROM ?_ibook_units'
        . ' WHERE ibook_id=?'
        , $ibook_id
    );
    foreach ($tmp_units as $uv) {
        $units[$uv['unit_num']][$uv['stud_id']] = $uv;
    }
}

//$dean = (preg_match('/(ВОПр)/', $ibook['grup_title'])) ? " Исакова А.Т" : " Азимова Г.Р.";
$is_do_abs = (preg_match('/(ВОПр)/', $ibook['grup_title'])) ? true : false;