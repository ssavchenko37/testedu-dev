<?php
$t_s_id = ($_POST['t_s_id']) ? $_POST['t_s_id']: 0;
$id = $_POST['pid'];

if (in_array($_POST['mode'], ["add_subj","edit_subj"])) {
	$subject = $TS->subject($_POST['subject_id']);
	$s_credits = ($subject['subject_credits'] < 4) ? $subject['subject_credits']: 4;
	$s_credits = floor($s_credits);

	$ins['grm_id'] = $_POST['grm_id'];
	$ins['tutor_id'] = $_POST['pid'];
	$ins['subject_id'] = $_POST['subject_id'];

	$ins_ibook = $ins;
	$ins_ibook['sheet_period'] = $sheet_period;
	$ins_ibook['semester_id'] = $_POST['scode'];
	$ins_ibook['ibook_type'] = $_POST['stype'];
	$ins_ibook['subject_credits'] = $subject['subject_credits'];
	$ins_ibook['modules'] = $s_credits;
	$ins_ibook['entered'] = $ins_ibook['modified'] = date('Y-m-d H:i:s');

	$ins_sheet = $ins;
	$ins_sheet['sheet_period'] = $sheet_period;
	$ins_sheet['sheet_type'] = $_POST['stype'];
	$ins_sheet['exam_id'] = ($subject['has_exam'] == 1) ? 0: NULL;
	$ins_sheet['semester_id'] = $_POST['scode'];
	$ins_sheet['modules'] = $s_credits;
	$ins_sheet['entered'] = $ins_sheet['modified'] = date('Y-m-d');

	$groups2ins = [];
	if ($_POST['mode'] == "add_subj") {
		$ins_subject = $ins;
		$ins_subject['period'] = $sheet_period;
		$ins_subject['stype'] = $_POST['stype'];
		$ins_subject['who_set'] = $ins_subject['who_upd'] = $tsdata['usr']['iid'];
		$ins_subject['entered'] = $ins_subject['modified'] = date('Y-m-d H:i:s');
		
		$t_s_id = $DB->query('INSERT INTO ?_tutor_subjects (?#) VALUES (?a)', array_keys($ins_subject), array_values($ins_subject));
		$groups2ins = $_POST['grup_ids'];
	}

	if ($_POST['mode'] == "edit_subj") {
		$upd['who_upd'] = $tsdata['usr']['iid'];
		$upd['modified'] = date('Y-m-d H:i:s');
		$DB->query('UPDATE ?_tutor_subjects SET ?a WHERE t_s_id=?', $upd, $t_s_id);
	
		$exist_groups = $DB->selectCol('SELECT grup_id FROM ?_tutor_groups WHERE t_s_id=?', $t_s_id);
		$diff = arrsIntersect($_POST['grup_ids'], $exist_groups);

		if (count($diff['newArr']) > 0) {
			$available = $DB->selectCol('SELECT TG.grup_id'
				. ' FROM ?_tutor_subjects TS'
				. ' INNER JOIN ?_tutor_groups TG'
				. ' WHERE TS.stype=? AND TS.t_s_id=? AND TG.t_s_id=? AND TG.grm_id=? AND TG.subject_id=?'
				, $_POST['stype'], $t_s_id, 0, $_POST['grm_id'], $_POST['subject_id']
			);
			foreach ($diff['newArr'] as $n_grup_id) {
				if (in_array($n_grup_id, $available)) {
					$exist_upd['t_s_id'] = $t_s_id;
					$exist_upd['tutor_id'] = $_POST['pid'];
					$DB->query('UPDATE ?_tutor_groups SET ?a WHERE t_s_id=? AND grm_id=? AND subject_id=? AND grup_id=?', $exist_upd, 0, $_POST['grm_id'], $_POST['subject_id'], $n_grup_id);
					$DB->query('UPDATE ?_ibook SET ?a WHERE t_s_id=? AND grm_id=? AND subject_id=? AND grup_id=?', $exist_upd, 0, $_POST['grm_id'], $_POST['subject_id'], $n_grup_id);
					$DB->query('UPDATE ?_3v_sheets SET ?a WHERE t_s_id=? AND grm_id=? AND subject_id=? AND grup_id=?', $exist_upd, 0, $_POST['grm_id'], $_POST['subject_id'], $n_grup_id);
				} else {
					$groups2ins[] = $n_grup_id;
				}
			}
		}

		if (count($diff['delArr']) > 0) {
			foreach ($diff['delArr'] as $d_grup_id) {
				$del['t_s_id'] = 0;
				$del['tutor_id'] = 0;
				$DB->query('UPDATE ?_tutor_groups SET ?a WHERE t_s_id=? AND grup_id=?', $del, $t_s_id, $d_grup_id);
				$DB->query('UPDATE ?_ibook SET ?a WHERE t_s_id=? AND grup_id=?', $del, $t_s_id, $d_grup_id);
				$DB->query('UPDATE ?_3v_sheets SET ?a WHERE t_s_id=? AND grup_id=?', $del, $t_s_id, $d_grup_id);
			}
		}
	}

	if (count($groups2ins) > 0) {
		foreach ($groups2ins as $r) {
			$tmp_grup['grup_id'] = $r;
			$tmp_grup['t_s_id'] = $t_s_id;
			$ins_grup = array_merge($ins, $tmp_grup);
			$DB->query('INSERT INTO ?_tutor_groups (?#) VALUES (?a)', array_keys($ins_grup), array_values($ins_grup));
	
			$ins_ibook['grup_id'] = $r;
			$ins_ibook['t_s_id'] = $t_s_id;
			$ibook_id = $DB->query('INSERT INTO ?_ibook (?#) VALUES (?a)', array_keys($ins_ibook), array_values($ins_ibook));

			$ins_sheet['grup_id'] = $r;
			$ins_sheet['t_s_id'] = $t_s_id;
			$sheet_id = $DB->query('INSERT INTO ?_3v_sheets (?#) VALUES (?a)', array_keys($ins_sheet), array_values($ins_sheet));
		}
	}
	// p($subject);
	// p($ins_subject);
	// p($ins_grup);
	// p($ins_ibook);
	// p($ins_sheet);
}

if ($_POST['mode'] == "delete_subj") {
	$DB->query('DELETE FROM ?_tutor_groups WHERE t_s_id=?', $t_s_id);
    $DB->query('DELETE FROM ?_tutor_subjects WHERE t_s_id=?', $t_s_id);
}

// header("Cache-control: private");
// header("HTTP/1.1 301 Moved Permanently");
// header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
// exit;