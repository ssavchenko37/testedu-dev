<?php
header('Content-Type: application/json; charset=utf-8');

$tsdata = $TS->tsdata();
$usr = $tsdata['usr']['iid'];

$json = file_get_contents('php://input');
$post = json_decode($json, true);

$re['status']  = 'error';

$mode = $post['mode'];
$sheet_id = $post['sheet_id'];
$item_id = $post['item_id'];

$rate = ($post['rate'] > 100) ? 100: $post['rate'];
$rate = ($post['rate'] < 0) ? 0: $rate;
$module_min = ($post['exam_id'] === "") ? MIN_PERCENT: MAX_TEST_SCORE;

$ins[$_POST['field']] = $rate;


$re['status']  = 'success';

echo json_encode($re);