<?php
// require_once 'thiscalss.php';
// $TStutors = new TS_tutors;
if (!empty($tsreq)) {
	$dcode = $TS->request_decode('dcode',$tsreq);
}

if (($_POST['mode'] ?? '')) {
	if (in_array($_POST['mode'], ['add','edit','delete'])) {
		include "action/action.php";
	}
	if (in_array($_POST['mode'], ['add_dept','edit_dept','delete_dept'])) {
		include "action/action_dept.php";
	}
	if (in_array($_POST['mode'], ['add_subj','edit_subj','delete_subj'])) {
		include "action/action_subj.php";
	}
}

$tutors_departments = $tutors_subjects = array();
foreach($TS->tutorDept() as $r) {
	$tutors_departments[$r['tutor_id']][] = $r;
}

foreach($TS->tutorSubj() as $r) {
	$tutors_subjects[$r['tutor_id']][] = $r;
}


if (!empty($dcode)) {
	$dcode = $TS->request_decode('dcode',$tsreq);
	$tutors = $DB->select('SELECT T.*'
		. ' FROM ?_tutor T'
		. ' INNER JOIN ?_tutor_dept TD ON T.tutor_id=TD.tutor_id'
		. ' INNER JOIN ?_departments D ON TD.dept_id=D.dept_id'
		. ' INNER JOIN ?_roles R ON TD.role_id=R.role_id'
		. ' WHERE D.dept_code=?'
		. ' ORDER BY T.tutor_fullru, T.tutor_fullname'
		, $dcode
	);
	$department = ($lang == "ru") ? $tmp[0]['dept_ru']: $tmp[0]['dept_title'];
} else {
	$tutors = $DB->select('SELECT *'
		. ' FROM ?_tutor ORDER BY tutor_fullru'
	);
}

$testing_qty = $DB->selectCol('SELECT tutor_id AS ARRAY_KEY, COUNT(module_id) AS qty FROM ?_module GROUP BY tutor_id');
$training_qty = $DB->selectCol('SELECT tutor_id AS ARRAY_KEY, COUNT(module_id) AS qty FROM ?_t_modules GROUP BY tutor_id');