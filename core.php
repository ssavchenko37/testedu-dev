<?php
if (strlen($tshash) != 18) die;

$js_path = json_encode($sPath);

$tsdata = $TS->tsdata();

$period = $TS->period();

if (($_POST['sheet_period'] ?? '')) {
	$sheet_period = $_POST['sheet_period'];
	setPeriod($sheet_period);
	$period = $TS->period($sheet_period);
}
$sheet_period = $period['uin'];

$facultyDean = '';
$globalMain = true;
$globalview = true;
$sCore = (!empty( $sPath[1] )) ? $sPath[1] : 'home';
$sMod = "_" . $tsdata['umod'];
$sCore = (empty( $sPath[1] ) && !empty(($tsdata['umod'] ?? ''))) ? $sMod : $sCore;
//$sCore = (!empty(($sPath[2] ?? ''))) ? $sCore . DIRECTORY_SEPARATOR . $sPath[2]: $sCore;

$usrAvaImg = "/assets/img/ava-admin-man.png";
$usrAvaAlt = "User";
if ( $tsdata['umod'] == "s") {
	if( file_exists(S_ROOT . "/" . S_PIC . "/" . $tsdata['usr']['stud_pic']) && !empty($tsdata['usr']['stud_pic'])) {
		$usrAvaImg = "/" . S_PIC . "/" . $tsdata['usr']['stud_pic'];
	} else {
		$usrAvaImg = "/" . S_PIC . "/no-pic.png";
	}
	$userName = $usrAvaAlt = build_stud_fio($tsdata['usr']['stud_name']);
}
if ( $tsdata['umod'] == "t") {
	if (file_exists(S_ROOT . "/" . S_AVA . "/" . $tsdata['usr']['ava_img']) && !empty($tsdata['usr']['ava_img'])) {
		$usrAvaImg = "/" . S_AVA . "/" . $tsdata['usr']['ava_img'];
	} else {
		$usrAvaImg = "/" . S_AVA . "/no-ava.png";
	}
	$userName = $usrAvaAlt = (!empty($tsdata['usr']['tutor_fullru']) && $lang == "ru") ? $tsdata['usr']['tutor_fullru']: $tsdata['usr']['tutor_fullname'];
	$facultyDean = ($tsdata['usr']['tutor_id'] == 53) ? 'ВОПр': $facultyDean;
	$facultyDean = ($tsdata['usr']['tutor_id'] == 214) ? 'DGP': $facultyDean;
}
if ( $tsdata['umod'] == "a") {
	$userName = $usrAvaAlt = $tsdata['usr']['description'];
}

if (is_file(S_ROOT . "/_core/" . $sCore . "/main.php") && $globalMain) {
	include S_ROOT . "/_core/" . $sCore . "/main.php";
}
if (is_file(S_ROOT . "/_core/" .$sMod . "/" . $sCore . "/main.php")) {
	include S_ROOT . "/_core/" .$sMod . "/" . $sCore . "/main.php";
}