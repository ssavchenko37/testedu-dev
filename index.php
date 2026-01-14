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

$tsdata = $TS->tsdata();

if (is_array($tsdata)) {
	if ($sPath[1] === 'api' && $_SERVER['REQUEST_METHOD'] === 'POST') {
		$handler = "_core/" . $sPath[2] . "/ajax/" . $sPath[3] . ".php";
		if (is_file($handler)) {
			require $handler;
		}
		exit;
	}
}

include 'core.php';

if (is_array($tsdata)) {
	include "inner.php";
} else {
	include "innex.php";
}