<?php
header('Content-Type: application/json; charset=utf-8');

$json = file_get_contents('php://input');
$post = json_decode($json, true);

if ($post['mode'] == "module") {
	$data = ($post['id'] > 0)
		? $module = $DB->selectRow('SELECT * FROM ?_3v_modules WHERE module_id=?', $post['id'])
		: []
	;
}

if ($post['mode'] == "subjects") {
	$scodes = $DB->selectCol('SELECT DISTINCT subject_code FROM ?_3v_chapters'
		. ' WHERE owners LIKE ?'
		, "%/" . $post['tutor_id'] . "/%"
	);
	$subjects = $DB->select('SELECT subject_code AS ARRAY_KEY, subject_title, subject_ru'
		. ' FROM ?_3v_subjects'
		. ' WHERE subject_code IN(?a)'
		, $scodes
	);
	$str = "";
	if (count($scodes) > 1) {
		$str .= "<option value=\"0\">" . _ll('Предмет') . "</option>";
	}
	foreach ($scodes as $scode) {
		$title = ($lang == "ru") ? $subjects[$scode]['subject_ru']: $subjects[$scode]['subject_title'];
		$str .= "<option value=\"" . $scode . "\">" . $title . "</option>";
	}
	$data['status']  = 'success';
	$data['options']  = $str;
}

if ($post['mode'] == "semesters") {
	$semeters = $DB->selectCol('SELECT DISTINCT chapter_semester FROM ?_3v_chapters'
		. ' WHERE subject_code = ?'
		, $post['module_subject']
	);
	$str = "";
	if (count($semeters) > 1) {
		$str .= "<option value=\"0\">" . _ll('Семестр') . "</option>";
	}
	foreach ($semeters as $sem) {
		$str .= "<option value=\"" . $sem . "\">" . $sem . "</option>";
	}
	$data['status']  = 'success';
	$data['options']  = $str;
}

if ($post['mode'] == "modules") {
	$mnums = $DB->selectCol('SELECT DISTINCT chapter_modul FROM ?_3v_chapters'
		. ' WHERE subject_code=? AND chapter_semester=?'
		, $post['module_subject'], $post['semester']
	);
	$str = "";
	if (count($mnums) > 1) {
		$str .= "<option value=\"0\">" . _ll('Модуль') . "</option>";
	}
	foreach ($mnums as $num) {
		$str .= "<option value=\"" . $num . "\">" . $num . "</option>";
	}
	$data['status']  = 'success';
	$data['options']  = $str;
}

if ($post['mode'] == "groups") {
	$sids = $DB->selectCol('SELECT subject_id FROM ?_3v_subjects'
		. ' WHERE subject_code=?'
		, $post['module_subject']
	);
	$sids = is_array($sids) ? $sids: array();

	$exist = array();

	$groups = $DB->select('SELECT G.grup_id, G.grup_title'
		. ' FROM ?_groups G'
		. ' INNER JOIN ?_groupments GRM ON G.dept_id=GRM.dept_id'
		. ' WHERE GRM.semester_id=?'
		. ' ORDER BY G.grup_id'
		, $post['semester']
	);

	$str = "";

	if (isset($post['module_id'])) {
		$module_groups = $DB->selectCell('SELECT module_groups FROM ?_3v_modules WHERE module_id=?', $post['module_id']);
		$gids = explode("/", preg_replace('/(^\/)|(\/$)/', '', $module_groups));
		$exist = $DB->select('SELECT grup_id, grup_title'
			. ' FROM ?_groups'
			. ' WHERE grup_id IN(?a)'
			. ' ORDER BY grup_id'
			, $gids
		);
		foreach ($groups as $g) {
			if(in_array($g['grup_id'], $exist)) {
				$str .= "<option value=\"" . $g['grup_id'] . "\" selected>" . $g['grup_title'] . "</option>";
			} else {
				$str .= "<option value=\"" . $g['grup_id'] . "\">" . $g['grup_title'] . "</option>";
			}
		}
	} else {
		$tmp = $DB->selectCol('SELECT module_groups'
			. ' FROM ?_3v_modules'
			. ' WHERE tutor_id=? AND sbj=? AND sem=? AND mdl=?'
			, $post['tutor_id'], $post['module_subject'], $post['semester'], $post['modulenum']
		);
		foreach ($tmp as $e) {
			$exist = array_merge($exist, explode("/", preg_replace('/(^\/)|(\/$)/', '', $e)));
		}
		foreach ($groups as $g) {
			if(!in_array($g['grup_id'], $exist)) {
				$str .= "<option value=\"" . $g['grup_id'] . "\">" . $g['grup_title'] . "</option>";
			}
		}
	}

	$data['status']  = 'success';
	$data['options']  = $str;

}

echo json_encode($data);
exit;