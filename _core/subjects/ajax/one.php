<?php
$id = $_POST['pid'];
$mode = $_POST['mod'];

$departments = ($lang == "ru") 
	? $DB->selectCol('SELECT dept_code AS ARRAY_KEY, CONCAT(dept_code, " ", dept_ru) FROM ?_departments ORDER BY dept_code')
	: $DB->selectCol('SELECT dept_code AS ARRAY_KEY, CONCAT(dept_code, " ", dept_title) FROM ?_departments ORDER BY dept_code')
;
$plans = $DB->selectCol('SELECT plan_id AS ARRAY_KEY, plan_title FROM ?_3v_plans ORDER BY plan_year');
$semesters = $DB->selectCol('SELECT semester_id AS ARRAY_KEY, semester_title FROM ?_3v_semesters ORDER BY semester_num');

$subject = [];
// p($_POST);
if ($mode == "add") {
	$sTTL = _ll('Добавить');
	$subject['plan_id'] = $_POST['filter_plan'];
	$subject['semester_id'] = $_POST['filter_semester'];
	$subject['dept_code'] = $_POST['filter_code'];
	$subject['has_exam'] = $_POST['filter_exams'];
}
if ($mode == "edit") {
	$sTTL = _ll('Редактировать');
	$subject = $TS->subject($id);
	// p($subject);
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">
	<input type="hidden" name="filter_plan" value="<?php echo $_POST['filter_plan']?>">
	<input type="hidden" name="filter_semester" value="<?php echo $_POST['filter_semester']?>">
	<input type="hidden" name="filter_code" value="<?php echo $_POST['filter_code']?>">
	<input type="hidden" name="filter_exams" value="<?php echo $_POST['filter_exams']?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php echo $sTTL?></h5>

		<div class="row mb-3">
			<label for="plan_id" class="col-sm-3 col-form-label text-end"><?php _l('План')?>:</label>
			<div class="col-sm-9">
				<select class="form-select" id="plan_id" name="plan_id">
					<option value="0"> -- <?php _l('Планы')?> -- </option>
					<?php echo getOptionsK($subject['plan_id'], $plans) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="semester_id" class="col-sm-3 col-form-label text-end"><?php _l('Cеместр')?>:</label>
			<div class="col-sm-9">
				<select class="form-select" id="semester_id" name="semester_id">
					<option value="0"> -- <?php _l('Cеместры')?> -- </option>
					<?php echo getOptionsK($subject['semester_id'], $semesters) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="dept_code" class="col-sm-3 col-form-label text-end"><?php _l('Кафедра') ?>:</label>
			<div class="col-sm-9">
				<select class="form-select" id="dept_code" name="dept_code">
					<option value="0"> -- <?php _l('Кафедры')?> -- </option>
					<?php echo getOptionsK($subject['dept_code'], $departments) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="subject_code" class="col-sm-3 col-form-label text-end"><?php _l('Код предмета') ?>:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="subject_code" name="subject_code" value="<?php if (isset($subject['subject_code'])) echo $subject['subject_code']?>">
			</div>
		</div>

		<div class="row mb-3">
			<label for="subject_title" class="col-sm-3 col-form-label text-end">Subject:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="subject_title" name="subject_title" value="<?php if (isset($subject['subject_title'])) echo $subject['subject_title']?>">
			</div>
		</div>

		<div class="row mb-3">
			<label for="subject_kg" class="col-sm-3 col-form-label text-end">Дисциплинасы:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="subject_kg" name="subject_kg" value="<?php if (isset($subject['subject_kg'])) echo $subject['subject_kg']?>">
			</div>
		</div>

		<div class="row mb-3">
			<label for="subject_ru" class="col-sm-3 col-form-label text-end">Дисциплина:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="subject_ru" name="subject_ru" value="<?php if (isset($subject['subject_ru'])) echo $subject['subject_ru']?>">
			</div>
		</div>

		<div class="row mb-3">
			<label for="subject_credits" class="col-sm-3 col-form-label text-end"><?php _l('Кредиты')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="subject_credits" name="subject_credits" value="<?php if (isset($subject['subject_credits'])) echo $subject['subject_credits']?>">
			</div>
		</div>

		<div class="row mb-3">
			<label for="subject_credits" class="col-sm-3 col-form-label text-end"><?php _l('Экзамен')?>:</label>
			<div class="col-sm-9">
				<div class="form-check form-switch">
					<input class="form-check-input" id="has_exam" name="has_exam" type="checkbox" role="switch" id="switchCheckChecked" <?php if($subject['has_exam'] == 1) echo "checked"?>>
					<label class="form-check-label" for="switchCheckChecked"><?php _l('Экзамен')?></label>
				</div>
			</div>
		</div>
		
		<div class="row mb-3">
			<div class="offset-sm-3 col-sm-9 d-flex justify-content-between">
				<button type="submit" class="btn btn-main w-50"> <?php _l('Сохранить')?> </button>
				<button class="btn btn-secondary dismiss-tsaside" type="button" aria-label="Close"> <?php _l('Отменить')?> </button>
			</div>
		</div>
		
	</div>
</form>