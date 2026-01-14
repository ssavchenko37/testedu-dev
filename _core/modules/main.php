<?php
if (($_POST['mode'] ?? '')) {
	include "action/action.php";
}

$start = 0;
$limit = 1000;

$schstr = $filter_dept = $filter_subject = $filter_sem = $filter_mdl = $filter_tutor = $filter_status = "";
if (($_POST ?? '')) {
	$schstr = trim($_POST['schstr']);
	$sql_search_word = '%'.strtolower($schstr).'%';
	$filter_dept = $_POST['filter_dept'];
	$filter_subject = $_POST['filter_subject'];
	$filter_sem = $_POST['filter_sem'];
	$filter_mdl = $_POST['filter_mdl'];
	$filter_tutor = $_POST['filter_tutor'];
	$filter_status = $_POST['filter_status'];
	$filter_daterange = false;
	if (!empty($_POST['filter_daterange'])) {
		$filter_daterange = true;
		$date_arr = explode(" — ", $_POST['filter_daterange']);
		$r_from	= $date_arr[0];
		$r_to	= (empty($date_arr[1])) ? date('Y-m-d'): $date_arr[1];
	}
}

$filter_departments = ($lang == "ru") 
	? $DB->selectCol('SELECT dept_code AS ARRAY_KEY, CONCAT(dept_code, ") ", dept_ru) FROM ?_departments ORDER BY dept_code')
	: $DB->selectCol('SELECT dept_code AS ARRAY_KEY, CONCAT(dept_code, ") ", dept_title) FROM ?_departments ORDER BY dept_code')
;

$filter_subjects = $filter_semesters = $filter_modules = $filter_tutors = [];
$tmp_sbj = $DB->select('SELECT S.subject_code AS ARRAY_KEY, S.subject_id, S.subject_code, S.subject_title, S.subject_ru'
	. ' FROM ?_3v_subjects S'
	. ' INNER JOIN ?_3v_chapters C ON S.subject_code=C.subject_code'
	. ' WHERE S.subject_code NOT IN (?a)'
	. ' ORDER BY subject_id DESC'
	, ["IGA","IGA2"]
);
foreach ($tmp_sbj as $code => $r) {
	$title = ($lang == "ru") ? $r['subject_ru']: $r['subject_title'];
	$filter_subjects[$code] = $r['subject_code'] . ") " . $title;
}


$tmp = $DB->select('SELECT * FROM ?_3v_modules');
$tutors_name = $TS->tutorsName();
foreach ($tmp as $r) {
	$filter_semesters[$r['sem']] = $r['sem'];
	$filter_modules[$r['mdl']] = $r['mdl'];
	$filter_tutors[$r['tutor_id']] = $tutors_name[$r['tutor_id']];
}
if ($tsdata['umod'] == "t") {
	$filter_tutors = [];
	$filter_tutors[$tsdata['usr']['tutor_id']] = ($lang == "ru") ? $tsdata['usr']['tutor_fullru']: $tsdata['usr']['tutor_fullname'];
	$filter_tutor = $tsdata['usr']['tutor_id'];
}

$modules = $DB->selectPage($total_pages,'SELECT *'
	. ', DATE_FORMAT(module_date, \'%d.%m.%Y\') as sDate'
	. ', DATE_FORMAT(module_date, \'%H:%i:%s\') as sTime'
	. ' FROM ?_3v_modules'
	. ' WHERE 1=1'
	. '{AND sbj=?}'
	. '{AND sem=?}'
	. '{AND mdl=?}'
	. '{AND tutor_id=?}'
	. '{AND module_status=?}'
	. '{AND module_date BETWEEN STR_TO_DATE(?, \'%Y-%m-%d %H:%i:%s\') AND STR_TO_DATE(?, \'%Y-%m-%d %H:%i:%s\')}'
	. ' ORDER BY module_date DESC'
	. ' LIMIT ?d, ?d'
	, empty($filter_subject) ? DBSIMPLE_SKIP : $filter_subject
	, empty($filter_sem) ? DBSIMPLE_SKIP : $filter_sem
	, empty($filter_mdl) ? DBSIMPLE_SKIP : $filter_mdl
	, empty($filter_tutor) ? DBSIMPLE_SKIP : $filter_tutor
	, empty($filter_status) ? DBSIMPLE_SKIP : $filter_status
	, ($filter_daterange) ? $r_from . " 00:00:00" : DBSIMPLE_SKIP, $r_to . " 23:59:59"
	, $start, $limit
);

$module_ids = array();
foreach( $modules as $r ) {
	$module_ids[] = $r['module_id'];
}
if(count($module_ids) > 0) {
	$results = $DB->select('SELECT module_id AS ARRAY_KEY, COUNT(result_id) AS res_total'
		. ' FROM ?_3v_module_results'
		. ' WHERE module_id IN(?a)'
		. ' GROUP BY module_id'
		, $module_ids
	);
}

$groups = $DB->selectCol('SELECT grup_id AS ARRAY_KEY, grup_title FROM ?_groups ORDER BY grup_id');