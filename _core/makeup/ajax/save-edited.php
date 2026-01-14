<?php
header('Content-Type: application/json; charset=utf-8');

$tsdata = $TS->tsdata();
$usr = $tsdata['usr']['iid'];
$tid = ($tsdata['umod'] == "a") ? $tsdata['usr']['id']: $tsdata['usr']['tutor_id'];

$json = file_get_contents('php://input');
$post = json_decode($json, true);

$re['status']  = 'error';
$mode = $post['mode'];
$ibook_id = $post['ibook_id'];

if ($mode == "trigger_abs") {
	if (!empty($post['item_id'])) {
		$item_id = $post['item_id'];
		$upd['is_abs'] = ($post['rate'] > 0) ? 1: NULL;
		$upd['who'] = $usr;
		$DB->query('UPDATE ?_ibook_items SET ?a WHERE item_id=?', $upd, $post['item_id']);
	}
	$checkup = $DB->selectRow('SELECT * FROM ?_ibook_items WHERE item_id=?', $item_id);

	$re['status'] = 'success';
	$re['item_id'] = $item_id;
	$re['trigger_class'] = ($checkup['is_abs'] == 1) ? 'bg-abs': 'bg-reabs';
}

if (!empty($ibook_id)) {
	$ibupd['modified'] = date('Y-m-d H:i:s');
	$DB->query('UPDATE ?_ibook SET ?a WHERE ibook_id=?', $ibupd, $ibook_id);
}

echo json_encode($re);

