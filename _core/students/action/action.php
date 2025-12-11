<?php
$id = $_POST['pid'];
$avaFolder = S_ROOT . DIRECTORY_SEPARATOR . S_AVA . DIRECTORY_SEPARATOR;
foreach ($_REQUEST as $rKey => $rVal) {
	if (in_array($rKey, array("dept_id","grup_id","stud_ru","stud_name","record_book","stud_uin","stud_email"))) {
		$ins[$rKey] = trim($rVal);
	}
}

if (!empty($_REQUEST['new_stud_pass'])) {
	$ins['stud_pass'] = $_REQUEST['new_stud_pass'];
}


if (empty($ins['stud_uin'])) {
	$ins['stud_uin'] = str2uin($ins['stud_name']);
	$exist_uin = $DB->selectRow('SELECT * FROM ?_students WHERE stud_uin=?', $ins['stud_uin']);
	$ins['stud_uin'] =  (count($exist_uin) == 0) ? $ins['stud_uin'] : $ins['stud_uin'] . "_2";
}

if (($_FILES['stud_pic']['error'] ?? '') == 0) {
	$iTmp = explode(".", $_FILES['stud_pic']['name']);
	$ext = end($iTmp);
	$iFile = "student_" . $ins['stud_uin'] . "." . $ext;
	$target_file = $avaFolder . $iFile;

	include S_ROOT . "/__outsider/wideimage/WideImage.php";
	$image = WideImage::load('stud_pic');
	$resized = $image->resize('256', '256', 'inside', 'down')->crop('center', 'middle', '256', '256');
	$resized->saveToFile($target_file);
	unset($image);
	$ins['stud_pic'] = $iFile;
}

if ($_POST['mode'] == "add") {
	$hash = substr(md5(uniqid(mt_rand(1000, 9999), true)), 0, 18);
	sscanf($hash, "%4s%s", $one, $two);
	$ins['hash'] = $two . "-" . $one;

	$DB->query('INSERT INTO ?_students (?#) VALUES (?a)', array_keys($ins), array_values($ins));
}
if ($_POST['mode'] == "edit") {
	$DB->query('UPDATE ?_students SET ?a WHERE stud_id=?', $ins, $id);
}
if ($_POST['mode'] == "delete") {
	$student = $TS->student($id);
	@unlink ($avaFolder . $student['stud_pic']);
	
	$DB->query('DELETE FROM ?_students WHERE stud_id=?', $id);
}