<?php
$id = $_POST['pid'];
foreach ($_REQUEST as $rKey => $rVal) {
	if (in_array($rKey, array("dept_code","dept_title","dept_ru"))) {
		$ins[$rKey] = trim($rVal);
	}
}


if ($_POST['mode'] == "add") {
	$DB->query('INSERT INTO ?_departments (?#) VALUES (?a)', array_keys($ins), array_values($ins));
}
if ($_POST['mode'] == "edit") {
	$DB->query('UPDATE ?_departments SET ?a WHERE dept_id=?', $ins, $id);
}
if ($_POST['mode'] == "delete") {
	$DB->query('DELETE FROM ?_departments WHERE dept_id=?', $id);
}