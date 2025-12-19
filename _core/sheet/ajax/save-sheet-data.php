<?php
require_once '../../../kernel.php';
header('Content-Type: application/json; charset=utf-8');

$tsdata = $TS->tsdata();
$usr = $tsdata['usr']['iid'];

$json = file_get_contents('php://input');
$post = json_decode($json, true);

$re['status']  = 'error';

$mode = $post['mode'];
$sheet_id = $post['sheet_id'];

if ($mode == "modules") {
	$sheet = $DB->selectRow('SELECT * FROM ?_3v_sheets WHERE sheet_id = ?', $sheet_id);
	$neededs = $DB->select('SELECT * FROM ?_3v_sheets WHERE sheet_period=? AND grm_id=? AND subject_id=?', $sheet['sheet_period'], $sheet['grm_id'], $sheet['subject_id']);
	if (count($neededs) > 0) {
		$upd['modules'] = $post['qty'];
		for ($i=$_POST['modules_qty']+1; $i < 5; $i++) {
			$this_uin = 'm' . $i . '_date';
			$upd[$this_uin] = NULL;
		}
		foreach ($neededs as $n) {
			$DB->query('UPDATE ?_3v_sheets SET ?a WHERE sheet_id=?', $upd, $n['sheet_id']);
			$sheet_items = $DB->select('SELECT * FROM ?_3v_sheet_items WHERE sheet_id=?', $n['sheet_id']);
			$module_min = ($sheet['exam_id'] === NULL) ? MIN_PERCENT: MAX_TEST_SCORE;
			foreach ($sheet_items as $row) {
				$modules_total = 0;
				$init = false;
				$qty = 0;
				$allowed = 1;
				$q = 0;
				foreach ($row as $k=>$r) {
					if(in_array($k, array('module1','module2','module3','module4'))) {
						if ($q < $post['qty']) {
							if ($allowed == 1) {
								$allowed = ($r < $module_min) ? 0 : $allowed;
							}
							$modules_total = $modules_total + $r;
							$q++;
							if ($r == 0) {
								$qty++;
							}
						}
					}
				}

				if (($qty == $post['qty'])) {
					$init = true;
				}
				$re['avg'] = ceil($modules_total/$q);
				$re['credit'] = ($init) ? 0: 1;
				$re['total'] = ($n['exam_id'] > 0) ? ceil(($row['score'] + $re['avg'])/2) : $re['avg'];
				$assest = ($allowed) ? get_assest($re['total'], array()): get_assest(1, array());
				$re['grade'] = $assest['number'] . " " . $assest['title'];

				$DB->query('UPDATE ?_3v_sheet_items SET ?a WHERE item_id=?', $re, $row['item_id']);
				if ($init) {
					$DB->query('UPDATE ?_3v_sheet_items SET `grade`=NULL WHERE item_id=?', $row['item_id']);
				}
			}
		}
	}
	$re['status']  = 'success';
}

if ($mode == "date") {
	$upd[$post['module']] = $post['m_date'];
	$DB->query('UPDATE ?_3v_sheets SET ?a WHERE sheet_id=?', $upd, $sheet_id);
	$checkup = $DB->selectRow('SELECT * FROM ?_3v_sheets WHERE sheet_id=?', $sheet_id);
	$re['date'] = $checkup[$post['module']];
	$re['status']  = 'success';
}

if ($mode == "assist") {
	$upd['assist'] = $post['assist'];
	$DB->query('UPDATE ?_3v_sheets SET ?a WHERE sheet_id=?', $upd, $sheet_id);
	$checkup = $DB->selectRow('SELECT * FROM ?_3v_sheets WHERE sheet_id=?', $sheet_id);
	$re['assist'] = $checkup['assist'];
	$re['status']  = 'success';
}

if ($mode == "assessments") {

	$re['status']  = 'success';
	$re['what'] = ($post['exam_id'] === "") ? 'eto null': 'eto 0';
	$re['post'] = $post;
}

echo json_encode($re);