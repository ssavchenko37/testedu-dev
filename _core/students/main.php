<?php
$grpcode = $TS->request_decode('grpcode',$tsreq);

if (($_POST['mode'] ?? '')) {
	if (in_array($_POST['mode'], ['add','edit','delete'])) {
		include "action/action.php";
	}
}

if ($grpcode > 0) {
	$group = $TS->group($grpcode);
	$groupment = $TS->groupment($group['dept_id']);
	$students = $DB->select('SELECT * FROM ?_students WHERE grup_id=? ORDER BY stud_id', $group['grup_id']);
	$request_dept_id = $TS->request_encode('gcode', $group['dept_id']);
}
