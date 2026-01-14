<?php
$ccode = $TS->request_decode('ccode',$tsreq);

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

$questions = $DB->select('SELECT *'
    . ' FROM ?_3v_questions'
    . ' WHERE 1=1'
    . ' {AND chapter_code=?}'
    . ' {AND (lower(chapter_code) LIKE ? OR lower(chapter_title) LIKE ?)}'
    . ' {AND subject_code=?}'
    . ' {AND lower(subject_code) LIKE ?}'
    . ' {AND chapter_code LIKE ?}'
    . ' {AND chapter_code LIKE ?}'
    . ' ORDER BY question_code'
    , empty($ccode) ? DBSIMPLE_SKIP : $ccode
    , ( !empty($schstr) ) ? $sql_search_word : DBSIMPLE_SKIP, $sql_search_word
    , empty($filter_subject) ? DBSIMPLE_SKIP : $filter_subject
    , empty($filter_dept) ? DBSIMPLE_SKIP :  $filter_dept .'%'
    , empty($filter_semester) ? DBSIMPLE_SKIP :  '____.' . $filter_semester .'.%'
    , empty($filter_module) ? DBSIMPLE_SKIP :  '____._.' . $filter_module .'.%'
);
if (!empty($ccode)) {
    [$filter_subject, $filter_semester, $filter_module, $theme] = explode('.',$ccode);
}

// $answersV3 = $DB->selectCol('SELECT question_code AS ARRAY_KEY, COUNT(answer_id) AS ans_total FROM ?_3v_answers GROUP BY question_code');

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