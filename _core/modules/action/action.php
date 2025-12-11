<?php

$id = $_POST['pid'];

if (in_array($_POST['mode'], $modulesMeta['modes'])) {
	foreach( $modulesMeta['modes'] as $k=>$e ) {
		if( $e == $_POST['mode'] ) {
			$DB->query('UPDATE ?_3v_modules SET module_status=? WHERE module_id=?', $k, $id);
		}
	}
}

if (in_array($_POST['mode'], ["add", "edit"])) {
	$ins['tutor_id'] = $_POST['tutor_id'];
	$ins['sbj'] = $_POST['module_subject'];
	$ins['sem'] = $_POST['module_semester'];
	$ins['mdl'] = $_POST['module_num'];
	$ins['module_date'] = $_POST['module_date'];
	$ins['module_duration'] = $_POST['module_duration'];
	$ins['module_desc'] = $_POST['module_desc'];
	$ins['module_groups'] = "/" . implode("/", array_unique($_POST['grup_ids'])) . "/";
}

if ($_POST['mode'] == "add") {
	$tsdata = $TS->tsdata();
	$ins['creator'] = $tsdata['usr']['iid'];
	$DB->query('INSERT INTO ?_3v_modules (?#) VALUES (?a)', array_keys($ins), array_values($ins));
}

if ($_POST['mode'] == "edit") {
	$DB->query('UPDATE ?_3v_modules SET ?a WHERE module_id=?', $ins, $id);
}

if ($_POST['mode'] == "delete") {
	$DB->query('DELETE FROM ?_3v_modules WHERE module_id=?', $id);
}

header("Cache-control: private");
header("HTTP/1.1 301 Moved Permanently");
header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
exit;