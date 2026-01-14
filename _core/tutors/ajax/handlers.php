<?php
header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents('php://input');
$post = json_decode($json, true);

$all_groups = $DB->select('SELECT * FROM ?_groups WHERE dept_id=?', $post['gid']);

$exist_groups = $DB->selectCol('SELECT TG.grup_id'
	. ' FROM ?_tutor_subjects TS'
	. ' INNER JOIN ?_tutor_groups TG ON TS.t_s_id=TG.t_s_id'
	. ' WHERE TS.stype=? AND TG.t_s_id<>? AND TG.grm_id=? AND TG.subject_id=?'
	, $post['stype'], 0, $post['gid'], $post['sid']
);

foreach ($all_groups as $g) {
	if(!in_array($g['grup_id'], $exist_groups)) {
		$str .= "<option value=\"" . $g['grup_id'] . "\">" . $g['grup_title'] . "</option>";
	}
}

$data['status']  = 'success';
$data['options']  = $str;

echo json_encode($data);