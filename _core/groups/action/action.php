<?php
$id = $_POST['pid'];
foreach ($_REQUEST as $rKey => $rVal) {
	if (in_array($rKey, array("dept_id", "grup_title", "plan_id", "semester_id"))) {
		$ins[$rKey] = trim($rVal);
	}
}
$ins['grup_uin'] = str2uin($ins['grup_title']);
$g_tmp = explode('-',$ins['grup_uin']);
$ins['grup_ord'] = $g_tmp[3] . '-' . $g_tmp[2] . '-' . $g_tmp[0];


if ($_POST['mode'] == "add") {
	$DB->query('INSERT INTO ?_groups (?#) VALUES (?a)', array_keys($ins), array_values($ins));
}
if ($_POST['mode'] == "edit") {
	$DB->query('UPDATE ?_groups SET ?a WHERE grup_id=?', $ins, $id);
}
if ($_POST['mode'] == "delete") {
	$DB->query('DELETE FROM ?_groups WHERE grup_id=?', $id);
}