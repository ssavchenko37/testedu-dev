<?php
header('Content-Type: application/json; charset=utf-8');

$usr = $tsdata['usr']['iid'];

$json = file_get_contents('php://input');
$post = json_decode($json, true);

$ibook_id = $post['ibook_id'];
$meta_id = -1;

if(empty($post['meta_id'])) {
	$ins['ibook_id'] = $ibook_id;
	$ins['meta_uin'] = $post['meta_uin'];
	$ins['meta_date'] = $post['meta_date'];
	$ins['meta_class'] = $DB->selectCell('SELECT ibook_type FROM ?_ibook WHERE ibook_id=?', $ibook_id);
	$ins['meta_hours'] = "2";

	if (!empty($ins['meta_date'])) {
		$meta_id = $DB->query('INSERT INTO ?_ibook_meta (?#) VALUES (?a)', array_keys($ins), array_values($ins));
	}
} else {
	$upd['meta_date'] = $post['meta_date'];
	$DB->query('UPDATE ?_ibook_meta SET ?a WHERE meta_id=?', $upd, $post['meta_id']);
	$meta_id = $post['meta_id'];
}

if (!empty($ibook_id)) {
	$ibupd['modified'] = date('Y-m-d H:i:s');
	$DB->query('UPDATE ?_ibook SET ?a WHERE ibook_id=?', $ibupd, $ibook_id);
}

$checkup = $DB->selectRow('SELECT *, DATE_FORMAT(meta_date, \'%m-%d\') AS monthday FROM ?_ibook_meta WHERE meta_id=?', $meta_id);

$data['meta_id'] = $checkup['meta_id'];
$data['meta_class'] = $checkup['meta_class'];
$data['meta_hours'] = $checkup['meta_hours'];
$data['monthday'] = $checkup['monthday'];

unset($checkup['monthday']);
$checkup['who'] = $usr;
$checkup['entered'] = date('Y-m-d H:i:s');
$DB->query('INSERT INTO ?_ibook_metabkp (?#) VALUES (?a)', array_keys($checkup), array_values($checkup));

echo json_encode($data);
exit;