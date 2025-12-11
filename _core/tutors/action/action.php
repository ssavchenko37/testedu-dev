<?php
$id = $_POST['pid'];
$avaFolder = S_ROOT . DIRECTORY_SEPARATOR . S_AVA . DIRECTORY_SEPARATOR;
foreach ($_REQUEST as $rKey => $rVal) {
	if (in_array($rKey, array("tutor_fullname","tutor_fullru","assistant","tutor_uin","tutor_email","tutor_pass"))) {
		$ins[$rKey] = trim($rVal);
	}
}
if (($_POST['tmp_fullname'] ?? '')) {
	list($ins['tutor_lastname'], $ins['tutor_name'], $ins['tutor_patronymic']) = explode(" ", $_POST['tmp_fullname']);
}

if (empty($ins['tutor_uin'])) {
	$ins['tutor_uin'] = str2uin($ins['tutor_fullname']);
	$exist_uin = $DB->selectRow('SELECT * FROM ?_tutor WHERE tutor_uin=?', $ins['tutor_uin']);
	$ins['tutor_uin'] =  (count($exist_uin) == 0) ? $ins['tutor_uin'] : $ins['tutor_uin'] . "_2";
}

if (($_FILES['ava_img']['error'] ?? '') == 0) {
	$iTmp = explode(".", $_FILES['ava_img']['name']);
	$ext = end($iTmp);
	$iFile = "tutor_" . $ins['tutor_uin'] . "." . $ext;
	$target_file = $avaFolder . $iFile;

	include S_ROOT . "/__outsider/wideimage/WideImage.php";
	$image = WideImage::load('ava_img');
	$resized = $image->resize('96', '96', 'inside', 'down')->crop('center', 'middle', '96', '96');
	$resized->saveToFile($target_file);
	unset($image);
	$ins['ava_img'] = $iFile;
}

if ($_POST['mode'] == "add") {
	$DB->query('INSERT INTO ?_tutor (?#) VALUES (?a)', array_keys($ins), array_values($ins));
}
if ($_POST['mode'] == "edit") {
	$DB->query('UPDATE ?_tutor SET ?a WHERE tutor_id=?', $ins, $id);
}
if ($_POST['mode'] == "delete") {
	$tutor = $TS->tutor($id)['tutor'];
	@unlink ($avaFolder . $tutor['ava_img']);
	$DB->query('DELETE FROM ?_tutor_dept WHERE tutor_id=?', $id);
	$DB->query('DELETE FROM ?_tutor_groups WHERE tutor_id=?', $id);
	$DB->query('DELETE FROM ?_tutor_subjects WHERE tutor_id=?', $id);
	
	$DB->query('DELETE FROM ?_tutor WHERE tutor_id=?', $id);
}