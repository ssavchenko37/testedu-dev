<?php
$t_d_id = $_POST['t_d_id'];
$id = $_POST['pid'];

$ins['tutor_id'] = $_POST['pid'];
$ins['dept_id'] = $_POST['dept_id'];
$ins['role_id'] = $_POST['role_id'];

if ($_POST['mode'] == "add_dept") {
	$ins['who_set'] = $tsdata['usr']['id'];
	$ins['entered'] = date('Y-m-d H:i:s');
	$DB->query('INSERT INTO ?_tutor_dept (?#) VALUES (?a)', array_keys($ins), array_values($ins));
}
if ($_POST['mode'] == "edit_dept") {
	$ins['who_update'] = $tsdata['usr']['id'];
	$ins['modified'] = date('Y-m-d H:i:s');
	$DB->query('UPDATE ?_tutor_dept SET ?a WHERE t_d_id=?', $ins, $t_d_id);
}
if ($_POST['mode'] == "delete_dept") {
	$DB->query('DELETE FROM ?_tutor_dept WHERE t_d_id=?', $t_d_id);
}

header("Cache-control: private");
header("HTTP/1.1 301 Moved Permanently");
header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
exit;