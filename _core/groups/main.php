<?php
$gcode = $TS->request_decode('gcode',$tsreq);

if (($_POST['mode'] ?? '')) {
	include "action/action.php";
}

if ($gcode > 0) {
	$dept = $DB->selectRow('SELECT * FROM ?_groupments WHERE dept_id=?', $gcode);
	$groups = $DB->select('SELECT * FROM ?_groups WHERE dept_id=? ORDER BY grup_ord + 1', $gcode);
	$s_qty = $DB->selectCol('SELECT grup_id AS ARRAY_KEY, COUNT(stud_id) FROM ?_students WHERE dept_id=? GROUP BY grup_id', $gcode);
}

