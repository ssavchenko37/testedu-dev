<?php
// $shcode = $TS->request_decode('shcode',$tsreq);
if (($_POST['mode'] ?? '')) {
	include "action/action.php";
}

$schstr = $filter_tutor = $filter_grm = $filter_grup = $filter_subject = "";
if (($_POST ?? '')) {
	$schstr = trim($_POST['schstr']);
	$sql_search_word = '%'.strtolower($schstr).'%';

	$filter_tutor = $_POST['filter_tutor'];
	$filter_grm = $_POST['filter_grm'];
	$filter_grup = $_POST['filter_grup'];
	$filter_subject = $_POST['filter_subject'];
}

if ($tsdata['umod'] == "t") {
	$tutor_id = $filter_tutor = $tsdata['usr']['tutor_id'];
}

$filter_groupments = $filter_groups = $filter_tutors = [];

$tmp = $DB->select('SELECT * FROM ?_3v_sheets WHERE sheet_type IS NOT NULL {AND tutor_id=?}{AND grm_id=?}{AND grup_id=?}{AND subject_id=?}'
	, (empty($filter_tutor)) ? DBSIMPLE_SKIP: $filter_tutor
	, (empty($filter_grm)) ? DBSIMPLE_SKIP: $filter_grm
	, (empty($filter_grup)) ? DBSIMPLE_SKIP: $filter_grup
	, (empty($filter_subject)) ? DBSIMPLE_SKIP: $filter_subject

);

$grm_title = $DB->select('SELECT dept_id AS ARRAY_KEY, dept_title, plan_id, semester_id FROM ?_groupments ORDER BY dept_ord');
$grup_title = $DB->select('SELECT grup_id AS ARRAY_KEY, grup_title, dept_id FROM ?_groups ORDER BY grup_ord');
$subj_title = $DB->select('SELECT S.subject_id AS ARRAY_KEY, S.plan_id, S.semester_id'
	. ', CONCAT(PLAN.plan_title, " / ", SEM.semester_title, " / ", S.subject_title) AS full_subject_en'
	. ', CONCAT(PLAN.plan_ru, " / ", SEM.semester_ru, " / ", S.subject_ru) AS full_subject_ru'
	. ' FROM ?_3v_subjects S'
	. ' INNER JOIN ?_3v_plans PLAN ON S.plan_id=PLAN.plan_id'
	. ' INNER JOIN ?_3v_semesters SEM ON S.semester_id=SEM.semester_id'
);
$tutors_name = $TS->tutorsName();
foreach ($tmp as $r) {
	$filter_tutors[$r['tutor_id']] = $tutors_name[$r['tutor_id']];
	$filter_groupments[$r['grm_id']] = $grm_title[$r['grm_id']]['dept_title'];
	$filter_groups[$r['grup_id']] = $grup_title[$r['grup_id']]['grup_title'];

	$filter_subjects[$r['subject_id']] = _lt([$subj_title[$r['subject_id']]['full_subject_ru'], $subj_title[$r['subject_id']]['full_subject_en']]);

	$tutor_grm[$r['tutor_id']]['grm'][$r['grm_id']] = $r['grm_id'];
}

$sheets = $DB->select('SELECT SH.*'
	. ', T.tutor_fullru, T.tutor_fullname'
	. ', GR.grup_title'
	. ', CONCAT(S.subject_code, " / ", S.subject_title) AS title_en'
	. ', CONCAT(S.subject_code, " / ", S.subject_ru) AS title_ru'
	. ', CONCAT(S.subject_code, " / ", S.subject_kg) AS title_kg'
	. ' FROM ?_3v_sheets SH'
	. ' INNER JOIN ?_tutor T ON SH.tutor_id=T.tutor_id'
	. ' INNER JOIN ?_groups GR ON SH.grup_id=GR.grup_id'
	. ' INNER JOIN ?_3v_subjects S ON SH.subject_id=S.subject_id'
	. ' WHERE SH.sheet_period=?'
	. '{AND SH.tutor_id=?}'
	. '{AND SH.grm_id=?}'
	. '{AND SH.grup_id=?}'
	. '{AND SH.subject_id=?}'
	. ' ORDER BY T.tutor_fullru, S.subject_code + 1'
	, $sheet_period
	, (empty($filter_tutor)) ? DBSIMPLE_SKIP: $filter_tutor
	, (empty($filter_grm)) ? DBSIMPLE_SKIP: $filter_grm
	, (empty($filter_grup)) ? DBSIMPLE_SKIP: $filter_grup
	, (empty($filter_subject)) ? DBSIMPLE_SKIP: $filter_subject
);
