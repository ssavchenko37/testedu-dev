<?php
$id = $_POST['pid'];
foreach ($_REQUEST as $rKey => $rVal) {
	if (in_array($rKey, array("dept_title", "grp_year", "plan_id", "semester_id"))) {
		$ins[$rKey] = trim($rVal);
	}
}
$ins['dept_uin'] = str2uin($ins['dept_title']);

if ($_POST['mode'] == "add") {
	$DB->query('INSERT INTO ?_groupments (?#) VALUES (?a)', array_keys($ins), array_values($ins));
}
if ($_POST['mode'] == "edit") {
	$DB->query('UPDATE ?_groupments SET ?a WHERE dept_id=?', $ins, $id);
}
if ($_POST['mode'] == "delete") {
	$DB->query('DELETE FROM ?_groupments WHERE dept_id=?', $id);
}