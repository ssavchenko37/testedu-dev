<?php
if (strlen($tshash) != 18) die;

$tutor_id = $tsdata['id'];
$tutor_dept = $TS->tutorDept($tutor_id);

$subjects = $scodes = array();
$chapter_data = $DB->select('SELECT DISTINCT subject_code AS ARRAY_KEY, subject_code, COUNT(subject_code) AS cnt FROM ?_3v_chapters WHERE owners LIKE ? GROUP BY subject_code'
	, "%/" . $tutor_id . "/%"
);
foreach ($chapter_data as $code=>$r) {
	$scodes[] = $r['subject_code'];
}
if (count($scodes) > 0) {
	$subjects = $DB->select('SELECT DISTINCT subject_code AS ARRAY_KEY, subject_code, subject_title, subject_ru, subject_id FROM ?_3v_subjects WHERE subject_code IN(?a)', $scodes);
}


$sheets = $TS->sheets(array("sheet_period"=>$period['uin'], "tutor_id"=>$tutor_id));

$ibooks = $TS->ibooks(array("sheet_period"=>$period['uin'], "tutor_id"=>$tutor_id));

$exam_se = $TS->currentExamDate($period['uin']);
$modules = $TS->modules(array("tutor_id"=>$tutor_id, "start"=>0, "limit"=>5));

$module_ids = array();
if( count($modules) > 0 ) {
	$module_ids = array();
	foreach ($modules as $m) {
		$module_ids[] = $m['module_id'];
	}
	$module_chapters = $DB->select('SELECT E.module_id AS ARRAY_KEY, C.chapter_id, C.chapter_title, S.subject_id, S.subject_title'
		. ', E.m_c_id, E.module_id, E.qty AS module_chapter_qty'
		. ' FROM ?_module_chapters E'
		. ' INNER JOIN ?_chapters C ON E.chapter_id=C.chapter_id'
		. ' INNER JOIN ?_subjects  S ON E.subject_id=S.subject_id'
		. ' WHERE E.module_id IN(?a)'
		, $module_ids
	);
	$module_groups = $DB->select('SELECT G.*, E.module_id'
		. ' FROM ?_module_groups E'
		. ' INNER JOIN ?_groups G ON E.grup_id=G.grup_id'
		. ' WHERE E.module_id IN(?a)'
		. ' ORDER BY G.grup_ord'
		, $module_ids
	);
}

$exams = $TS->exams(array("tutor_id"=>$tutor_id, "exam_se"=>$exam_se, "start"=>0, "limit"=>5));
if (count($exams) == 0) {
	$exams = $DB->select('SELECT *'
		. ', DATE_FORMAT(exam_date, \'%d.%m.%Y\') as sDate'
		. ', DATE_FORMAT(exam_date, \'%H:%i:%s\') as sTime'
		. ' FROM ?_exam'
		. ' WHERE exam_status<? AND tutor_id=?'
		. ' ORDER BY exam_date DESC'
		. ' LIMIT 5'
		, 3
		, $tutor_id
	);
}
if( count($exams) > 0 ) {
	$exam_ids = array();
	foreach( $exams as $k=>$r ) {
		$exam_ids[] = $r['exam_id'];
	}
	$exam_groups = $DB->select('SELECT G.*, E.exam_id FROM ?_exam_groups E INNER JOIN ?_groups G ON E.grup_id=G.grup_id WHERE E.exam_id IN(?a)', $exam_ids);
	$exam_chapters = $DB->select('SELECT C.*, S.*, E.exam_id FROM ?_exam_chapters E'
		. ' INNER JOIN ?_chapters C ON E.chapter_id=C.chapter_id'
		. ' INNER JOIN ?_subjects S ON E.subject_id=S.subject_id'
		. ' WHERE E.exam_id IN(?a)'
		, $exam_ids
	);
}



