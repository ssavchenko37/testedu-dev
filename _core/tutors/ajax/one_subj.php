<?php
require_once '../../../kernel.php';
$id = $_POST['pid'];
$mode = $_POST['mod'];

$tutor_groups = $dept_subj = $subjects = $departments = $semesters = $groups = array();

if ($mode == "edit_subj") {
	$t_s_id = $id;
	$re = $DB->selectRow('SELECT * FROM ?_tutor_subjects WHERE t_s_id=?', $id);
	$tutor_id = $re['tutor_id'];
	$subject = $TS->subject($re['subject_id']);
	$dept_code = $subject['dept_code'];
	$semester_id = $subject['semester_id'];
	$subject_id = $re['subject_id'];
	$grm_id = $re['grm_id'];
	$tutor_groups = $DB->selectCol('SELECT grup_id FROM ?_tutor_groups WHERE t_s_id=?', $id);
	$unavailable = $DB->selectCol('SELECT TG.grup_id'
		. ' FROM ?_tutor_subjects TS'
		. ' INNER JOIN ?_tutor_groups TG ON TS.t_s_id=TG.t_s_id'
		. ' WHERE TS.stype=? AND TG.t_s_id<>? AND TG.grm_id=? AND TG.subject_id=?'
		, $re['stype'], $t_s_id, $re['grm_id'], $re['subject_id']
	);
	$tmp_grups = $DB->select('SELECT G.*, GRM.semester_id'
		. ' FROM ?_groups G'
		. ' INNER JOIN ?_groupments GRM ON G.dept_id=GRM.dept_id'
		. ' WHERE GRM.semester_id=? AND G.grup_id NOT IN (?a)'
		. ' ORDER BY G.grup_id'
		, $subject['semester_id'], $unavailable
	);
	foreach ($tmp_grups as $g) {
		$groups[$g['grup_id']] = $g['grup_title'];
	}

} else {
	$t_s_id = "";
	$tutor_id = $id;
	$semester_id = 0;
	$grm_id = 0;
}

$tutor = $TS->tutor($tutor_id)['tutor'];
$tutor_dept = $TS->tutorDept($tutor_id);

foreach ($tutor_dept as $d) {
	$dtitle =  ($lang == "ru") ? $d['dept_ru']: $d['dept_title'];
	$departments[$d['dept_code']]['title'] = $d['dept_code'] . ") " . $dtitle;
	$departments[$d['dept_code']]['dcode'] = $d['dept_code'];
}
if ($mode == "add_subj" && count($departments) == 1) {
	$dept_code = $tutor_dept[0]['dept_code'];
}

foreach ($tutor_dept as $d) {
	$tmp_subj = $DB->select('SELECT S.subject_id, S.subject_code, SEM.semester_num AS sem'
		. ', CONCAT(PLAN.plan_title, " / sem.", SEM.semester_num, " / ", S.subject_code, ": ", S.subject_title) AS subject_fullen'
		. ', CONCAT(PLAN.plan_ru, " / сем.", SEM.semester_num, " / ", S.subject_code, ": ", S.subject_ru) AS subject_fullru'
		. ' FROM ?_3v_subjects S'
		. ' INNER JOIN ?_3v_plans PLAN ON S.plan_id=PLAN.plan_id'
		. ' INNER JOIN ?_3v_semesters SEM ON S.semester_id=SEM.semester_id'
		. ' WHERE PLAN.hide=? AND S.dept_code=?'
		. ' ORDER BY PLAN.plan_id DESC, S.semester_id, S.subject_uin'
		, 0
		, $d['dept_code']
	);
	$dept_subj = array_merge($dept_subj, $tmp_subj);
}
$tmp_semesters = $DB->select('SELECT * FROM ?_3v_semesters ORDER BY semester_id');
foreach ($tmp_semesters as $s) {
	$semesters[$s['semester_id']]['title'] = ($lang == "ru") ? $s['semester_ru']: $s['semester_title'];
	$semesters[$s['semester_id']]['scode'] = $s['semester_id'];
}
foreach ($dept_subj as $r) {
	$subjects[$r['subject_id']]['title'] = ($lang == "ru") ? $r['subject_fullru']: $r['subject_fullen'];
	$subjects[$r['subject_id']]['dcode'] = explode("S", $r['subject_code'])[0];
	$subjects[$r['subject_id']]['scode'] = $r['sem'];
}
$tmp_grms = $DB->select('SELECT * FROM ?_groupments WHERE semester_id<? AND semester_id>? ORDER BY dept_ord', 11, 0);
foreach ($tmp_grms as $g) {
	$groupments[$g['dept_id']]['title'] = $g['dept_title'];
	$groupments[$g['dept_id']]['grmid'] = $g['dept_id'];
	$groupments[$g['dept_id']]['scode'] = $g['semester_id'];
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $tutor_id?>">
	<input type="hidden" id="tsid" name="t_s_id" value="<?php echo $t_s_id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php _l('Преподаватель')?> <?php echo _lt([$tutor['tutor_fullru'], $tutor['tutor_fullname']])?></h5>

		<div class="row mb-3">
			<label for="dcode" class="col-sm-3 col-form-label text-end"><?php _l('Кафедра')?>:</label>
			<div class="col-sm-9">
				<select class="form-control" id="dcode" name="dcode">
					<?php if (empty($dept_code)) { ?> <option value="0"> -- <?php _l('Кафедра')?> -- </option> <?php } ?>
					<?php echo getOptionsData($dept_code, $departments) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="scode" class="col-sm-3 col-form-label text-end"><?php _l('Семестр')?>:</label>
			<div class="col-sm-9">
				<select class="form-control" id="scode" name="scode">
					<option value="0"> -- <?php _l('Семестр')?> -- </option>
					<?php echo getOptionsData($semester_id, $semesters) ?>					
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="subject_id" class="col-sm-3 col-form-label text-end"><?php _l('Предмет')?>:<sup class="text-danger">*</sup></label>
			<div class="col-sm-9">
				<select class="form-control" id="subject_id" name="subject_id">
					<option value="0"> -- <?php _l('Предмет')?> -- </option>
					<?php echo getOptionsData($subject_id, $subjects) ?>
				</select>
			</div>
		</div>
		<div class="row mb-3">
			<label class="col-sm-3 col-form-label text-end"><?php _l('Тип')?>:<sup class="text-danger">*</sup></label>
			<div class="col-sm-9 pt-2">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="stype" id="stypeL" value="lc"<?php if($re['stype'] == "lc") echo " checked"?>>
					<label class="form-check-label" for="stypeL"><?php _l('Лекция')?></label>
				</div>
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="stype" id="stypeP" value="pr"<?php if($re['stype'] == "pr") echo " checked"?>>
					<label class="form-check-label" for="stypeP"><?php _l('Практика')?></label>
				</div>
			</div>
		</div>

		<div class="row mb-3">
			<label for="grm_id" class="col-sm-3 col-form-label text-end"><?php _l('Поток')?>:<sup class="text-danger">*</sup></label>
			<div class="col-sm-9">
				<select class="form-control" id="grm_id" name="grm_id">
					<option value="0"> -- <?php _l('Поток')?> -- </option>
					<?php echo getOptionsData($grm_id, $groupments) ?>			
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="grup_ids" class="col-sm-3 col-form-label text-end"><?php _l('Группы')?>:<sup class="text-danger">*</sup></label>
			<div class="col-sm-9">
				<select class="form-control" multiple="" size="5" id="grup_ids" name="grup_ids[]">
					<?php echo getOptionsMultiple($tutor_groups, $groups) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<div class="offset-sm-3 col-sm-9 d-flex justify-content-between">
				<button type="submit" id="action_subj" class="btn btn-main w-50" disabled=""> <?php _l('Сохранить')?> </button>
				<button class="btn btn-secondary dismiss-tsaside" type="button" aria-label="Close"> <?php _l('Отменить')?> </button>
			</div>
		</div>

	</div>

</form>