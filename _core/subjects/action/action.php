<?php
$id = $_POST['pid'];

foreach ($_REQUEST as $rKey => $rVal) {
	if (in_array($rKey, array("plan_id","semester_id","dept_code","subject_code","subject_title","subject_kg","subject_ru","subject_credits"))) {
		$ins[$rKey] = trim($rVal);
	}
}
$ins['subject_modified'] = date('Y-m-d');

if ($_POST['mode'] == "add") {
	$ins['subject_entered'] = date('Y-m-d');
	$DB->query('INSERT INTO ?_3v_subjects (?#) VALUES (?a)', array_keys($ins), array_values($ins));
}
if ($_POST['mode'] == "edit") {
	$DB->query('UPDATE ?_3v_subjects SET ?a WHERE subject_id=?', $ins, $id);
}
if ($_POST['mode'] == "delete") {
	$DB->query('DELETE FROM ?_3v_subjects WHERE subject_id=?', $id);
}