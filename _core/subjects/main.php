<?php
$dcode = $TS->request_decode('dcode',$tsreq);
$scode = $TS->request_decode('scode',$tsreq);
if (($_POST['mode'] ?? '')) {
	include "action/action.php";
}

$schstr = trim($_POST['schstr']);
$sql_search_word = '%'. mb_strtolower($schstr,'UTF-8') .'%';

$filter_plan = (isset($_POST['filter_plan'])) ? $_POST['filter_plan']: 0;
$filter_semester = (isset($_POST['filter_semester'])) ? $_POST['filter_semester']: 0;
$filter_code = ($_POST['filter_code'] != "") ? $_POST['filter_code']: "";
$filter_exams = $_POST['filter_exams'];

$subjects = $DB->select('SELECT S.*, SEM.semester_title, SEM.semester_num, PLAN.plan_title, PLAN.plan_year'
	. ' FROM ?_3v_subjects S'
	. ' INNER JOIN ?_3v_plans PLAN ON S.plan_id=PLAN.plan_id'
	. ' INNER JOIN ?_3v_semesters SEM ON S.semester_id=SEM.semester_id'
	. ' WHERE PLAN.hide=?'
	. ' {AND S.plan_id=?}'
	. ' {AND S.semester_id=?}'
	. ' {AND S.dept_code=?}'
	. ' {AND S.has_exam=?}{AND S.has_exam=?}'
	. ' {AND (lower(S.subject_title) LIKE ? OR lower(S.subject_ru) LIKE ? OR lower(S.subject_code) LIKE ?)}'
	. ' {AND S.dept_code=?}'
	. ' {AND S.subject_code=?}'
	, 0
	, ( $filter_plan > 0 ) ? $filter_plan : DBSIMPLE_SKIP
	, ( $filter_semester > 0 ) ? $filter_semester : DBSIMPLE_SKIP
	, empty($filter_code) ? DBSIMPLE_SKIP : $filter_code
	, ($filter_exams == 1) ? $filter_exams : DBSIMPLE_SKIP, ($filter_exams == 2) ? 0 : DBSIMPLE_SKIP
	, ( !empty($schstr) ) ? $sql_search_word : DBSIMPLE_SKIP, $sql_search_word, $sql_search_word
	, ($dcode == 0) ? DBSIMPLE_SKIP : $dcode
	, ($scode == 0) ? DBSIMPLE_SKIP : $scode
);

$chaptersV3 = $DB->selectCol('SELECT subject_code AS ARRAY_KEY, COUNT(chapter_id) AS chap_total FROM ?_3v_chapters GROUP BY subject_code');

$departments = ($lang == "ru") 
	? $DB->selectCol('SELECT dept_code AS ARRAY_KEY, CONCAT(dept_code, " ", dept_ru) FROM ?_departments ORDER BY dept_code')
	: $DB->selectCol('SELECT dept_code AS ARRAY_KEY, CONCAT(dept_code, " ", dept_title) FROM ?_departments ORDER BY dept_code')
;

$plans = $DB->selectCol('SELECT plan_id AS ARRAY_KEY, plan_title FROM ?_3v_plans');
$semesters = $DB->selectCol('SELECT semester_id AS ARRAY_KEY, semester_title FROM ?_3v_semesters');