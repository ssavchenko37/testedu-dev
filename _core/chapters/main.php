<?php
$scode = $TS->request_decode('scode',$tsreq);
if (($_POST['mode'] ?? '')) {
	include "action/action.php";
}

$schstr = trim($_POST['schstr']);
$sql_search_word = '%'. mb_strtolower($schstr,'UTF-8') .'%';

$filter_semester = ($_POST['filter_semester'] != "") ? $_POST['filter_semester']: "";
$filter_module = ($_POST['filter_module'] != "") ? $_POST['filter_module']: "";
$filter_dept = ($_POST['filter_dept'] != "") ? $_POST['filter_dept']: "";
$filter_subject = ($_POST['filter_subject'] != "") ? $_POST['filter_subject']: "";

if ($mode != "all") {
	$schstr = trim($_POST['schstr']);
	$sql_search_word = '%'. mb_strtolower($schstr,'UTF-8') .'%';
}

$chapters = $DB->select('SELECT *'
	. ' FROM ?_3v_chapters'
	. ' WHERE 1=1'
	. ' {AND (lower(chapter_code) LIKE ? OR lower(chapter_title) LIKE ?)}'
	. ' {AND subject_code=?}'
	. ' {AND subject_code=?}'
	. ' {AND chapter_semester=?}'
	. ' {AND chapter_modul=?}'
	. ' {AND lower(subject_code) LIKE ?}'
	. ' ORDER BY chapter_code'
	, !empty($schstr) ? $sql_search_word : DBSIMPLE_SKIP, $sql_search_word
	, empty($scode) ? DBSIMPLE_SKIP : $scode
	, empty($filter_subject) ? DBSIMPLE_SKIP : $filter_subject
	, empty($filter_semester) ? DBSIMPLE_SKIP : $filter_semester
	, empty($filter_module) ? DBSIMPLE_SKIP : $filter_module
	, empty($filter_dept) ? DBSIMPLE_SKIP : '%'. strtolower($filter_dept) .'%'
);

$questionsV3 = $DB->selectCol('SELECT chapter_code AS ARRAY_KEY, COUNT(question_id) AS qst_total FROM ?_3v_questions GROUP BY chapter_code');

$modules = $DB->selectCol('SELECT DISTINCT chapter_modul AS ARRAY_KEY, chapter_modul FROM ?_3v_chapters WHERE chapter_modul>?', 0); 

$departments = ($lang == "ru") 
	? $DB->selectCol('SELECT dept_code AS ARRAY_KEY, CONCAT(dept_code, " ", dept_ru) FROM ?_departments ORDER BY dept_code')
	: $DB->selectCol('SELECT dept_code AS ARRAY_KEY, CONCAT(dept_code, " ", dept_title) FROM ?_departments ORDER BY dept_code')
;
$semesters = $DB->selectCol('SELECT semester_id AS ARRAY_KEY, semester_title FROM ?_3v_semesters');

$subjects = array();
$tmp = $DB->select('SELECT DISTINCT subject_code AS ARRAY_KEY, subject_id, subject_code, subject_ru, subject_title'
	. ' FROM ?_3v_subjects'
	. ' WHERE subject_code IS NOT NULL'
	. ' {AND dept_code=?}'
	. ' ORDER BY subject_code, subject_id DESC'
	, empty($filter_dept) ? DBSIMPLE_SKIP : $filter_dept
);
foreach ($tmp as $r) {
	$tmp_title =  ($lang == "ru") ? $r['subject_ru'] : $r['subject_title'];
	$subjects[$r['subject_code']] = $r['subject_code'] . " " . $tmp_title;
}

$tutors = ($lang == "ru") 
	? $DB->selectCol('SELECT tutor_id AS ARRAY_KEY, CONCAT(tutor_id, " ", tutor_fullru) FROM ?_tutor ORDER BY tutor_fullru')
	: $DB->selectCol('SELECT tutor_id AS ARRAY_KEY, CONCAT(tutor_id, " ", tutor_fullname) FROM ?_tutor ORDER BY tutor_fullname')
;