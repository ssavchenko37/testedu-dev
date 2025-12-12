<?php
if (empty($tsdata['usr']['tutor_dean'])) exit;

$ibcode = $TS->request_decode('ibcode',$tsreq);

$schstr = $filter_tutor = $filter_grm = $filter_grup = $filter_subject = "";
if (($_POST ?? '')) {
	$schstr = trim($_POST['schstr']);
	$sql_search_word = '%'.strtolower($schstr).'%';

	$filter_tutor = $_POST['filter_tutor'];
	$filter_grm = $_POST['filter_grm'];
	$filter_grup = $_POST['filter_grup'];
	$filter_subject = $_POST['filter_subject'];
}

$absents = $DB->select('SELECT DISTINCT iI.ibook_id, iB.sheet_period, iB.grup_id, iB.grm_id, iB.grm_id, iB.tutor_id, iB.subject_id, G.grup_title'
	. ' FROM ?_ibook_items iI'
	. ' INNER JOIN ?_ibook iB ON iI.ibook_id=iB.ibook_id'
	. ' INNER JOIN ?_groups G ON iB.grup_id=G.grup_id'
	. ' WHERE is_abs=?'
	. ' AND iB.sheet_period=?'
	. ' AND grup_title LIKE(?)'
	. '{AND iB.grm_id=?}'
	. '{AND iB.grup_id=?}'
	. '{AND iB.tutor_id=?}'
	. '{AND iB.subject_id=?}'
	, 1
	, $sheet_period
	, '%' . $tsdata['usr']['tutor_dean'] . '%'
	, (empty($filter_grm)) ? DBSIMPLE_SKIP: $filter_grm
	, (empty($filter_grup)) ? DBSIMPLE_SKIP: $filter_grup
	, (empty($filter_tutor)) ? DBSIMPLE_SKIP: $filter_tutor
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
foreach($absents as $r) {
	$filter_tutors[$r['tutor_id']] = $tutors_name[$r['tutor_id']];
	$filter_groupments[$r['grm_id']] = $grm_title[$r['grm_id']]['dept_title'];
	$filter_groups[$r['grup_id']] = $grup_title[$r['grup_id']]['grup_title'];
	$filter_subjects[$r['subject_id']] = _lt([$subj_title[$r['subject_id']]['full_subject_ru'], $subj_title[$r['subject_id']]['full_subject_en']]);
}
