<?php
header('Content-Type: application/json; charset=utf-8');

$tsdata = $TS->tsdata();
$usr = '';

$usr = $tsdata['usr']['iid'];
$tid = ($tsdata['umod'] == "a") ? $tsdata['usr']['id']: $tsdata['usr']['tutor_id'];

$json = file_get_contents('php://input');
$post = json_decode($json, true);

$re['status']  = 'error';
$mode = $post['mode'];
$ibook_id = $post['ibook_id'];

if ($mode == "edited_meta") {
	$upd[$post['field']] = $post['rate'];
	$DB->query('UPDATE ?_ibook_meta SET ?a WHERE meta_id=?', $upd, $post['meta_id']);
	$checkup = $DB->selectRow('SELECT * FROM ?_ibook_meta WHERE meta_id=?', $post['meta_id']);
	$checkup['who'] = $usr;
	$checkup['entered'] = date('Y-m-d H:i:s');
	$DB->query('INSERT INTO ?_ibook_metabkp (?#) VALUES (?a)', array_keys($checkup), array_values($checkup));

	$re['status'] = 'success';
	$re['value'] = $checkup[$post['field']];
}

if ($mode == "edited_val") {
	// $ts_sys = json_decode($_COOKIE['ts_sys']);
	$item_id = -1;
	if (empty($post['item_id'])) {
		$ins['ibook_id'] = $ibook_id;
		$ins['item_uin'] = $post['item_uin'];
		$ins['stud_id'] = $post['stud_id'];
		$ins['item_val'] = trim($post['rate']);
		if ($post['rate'] == 'abs') {
			$ins['is_abs'] = 1;
		}
		$ins['who'] = $usr;

		$exist = $DB->selectRow('SELECT * FROM ?_ibook_items WHERE ibook_id=? AND item_uin=? AND stud_id=?', $ins['ibook_id'], $ins['item_uin'], $ins['stud_id']);
		if (count($exist) > 0) {
			$upd_exist['item_val'] = trim($post['rate']);
			$upd['who'] = $usr;
			$DB->query('UPDATE ?_ibook_items SET ?a WHERE item_id=?', $upd_exist, $exist['item_id']);
			$item_id = $exist['item_id'];
		} else {
			$item_id = $DB->query('INSERT INTO ?_ibook_items (?#) VALUES (?a)', array_keys($ins), array_values($ins));
		}
	} else {
		$item_id = $post['item_id'];
		$upd['item_val'] = trim($post['rate']);
		$upd['who'] = $usr;
		$DB->query('UPDATE ?_ibook_items SET ?a WHERE item_id=?', $upd, $post['item_id']);
	}

	$checkup = $DB->selectRow('SELECT * FROM ?_ibook_items WHERE item_id=?', $item_id);
	$checkup['entered'] = date('Y-m-d H:i:s');
	$DB->query('INSERT INTO ?_ibook_itemsbkp (?#) VALUES (?a)', array_keys($checkup), array_values($checkup));

	$re['item_id'] = $item_id;
	$re['status'] = 'success';
	$re['value'] = $checkup['item_val'];
}

if ($mode == "edited_unit") {
	$unit_id = -1;
	$max_rate = 40;
	$max_rate = ($post['field'] == "score_atten") ? 20: $max_rate;
	$rate = (int)$post['rate'];
	$rate = ($rate > $max_rate) ? $max_rate: $rate; 
	
	if (empty($post['unit_id'])) {
		$ins['ibook_id'] = $ibook_id;
		$ins['stud_id'] = $post['stud_id'];
		$ins['unit_num'] = $post['unit_num'];
		$ins[$post['field']] = $rate;
		$ins['who'] = $usr;
		$unit_id = $DB->query('INSERT INTO ?_ibook_units (?#) VALUES (?a)', array_keys($ins), array_values($ins));
	} else {
		$unit_id = $post['unit_id'];
		$upd[$post['field']] = (empty($rate)) ? NULL: $rate;
		$upd['who'] = $usr;
		$DB->query('UPDATE ?_ibook_units SET ?a WHERE unit_id=?', $upd, $unit_id);
	}
	$unit = $DB->selectRow('SELECT * FROM ?_ibook_units WHERE unit_id=?', $unit_id);
	$re['total'] = $ttlupd['total'] = $unit['score_atten'] + $unit['score_curr'] + $unit['score_contr'];
	$DB->query('UPDATE ?_ibook_units SET ?a WHERE unit_id=?', $ttlupd, $unit['unit_id']);

	$checkup = $DB->selectRow('SELECT * FROM ?_ibook_units WHERE unit_id=?', $unit_id);
	$checkup['entered'] = date('Y-m-d H:i:s');
	$DB->query('INSERT INTO ?_ibook_unitsbkp (?#) VALUES (?a)', array_keys($checkup), array_values($checkup));

	$re['unit_id'] = $unit_id;
	$re['unit_num'] = $unit['unit_num'];
	$re['status'] = 'success';
	$re['value'] = $unit[$post['field']];
}

if (!empty($ibook_id)) {
	$ibupd['modified'] = date('Y-m-d H:i:s');
	$DB->query('UPDATE ?_ibook SET ?a WHERE ibook_id=?', $ibupd, $ibook_id);
}

echo json_encode($re);

