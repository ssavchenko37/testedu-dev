<?php
require_once 'kernel.php';

if(!isset($sPath)) {
	$sPath = array();
}

if (($sPath[1] ?? '') == "logout") {
	setcookie ("ts_sys", 0, time() - 3600, "/");
	header("Location: /");
	die();
}

$tshash = substr(md5(uniqid(mt_rand(1000, 9999), true)), 0, 18);

include 'core.php';

if (is_array($tsdata)) {
	include "inner.php";
} else {
	include "innex.php";
}