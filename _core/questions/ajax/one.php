<?php
$id = $_POST['pid'];
$mode = $_POST['mod'];

$modules = $DB->selectCol('SELECT DISTINCT chapter_modul AS ARRAY_KEY, chapter_modul FROM ?_3v_chapters'); 
$semesters = $DB->selectCol('SELECT semester_id AS ARRAY_KEY, semester_title FROM ?_3v_semesters');
$subjects = array();
$tmp = $DB->select('SELECT DISTINCT subject_code AS ARRAY_KEY, subject_id, subject_code, subject_ru, subject_title'
	. ' FROM ?_3v_subjects'
	. ' WHERE subject_code IS NOT NULL'
	. ' {AND dept_code=?}'
	. ' ORDER BY subject_code, subject_id DESC'
	, empty($filter_dept) ? DBSIMPLE_SKIP : $filter_dept
);
foreach ($tmp as $r) {
	$tmp_title =  ($lang == "ru") ? $r['subject_ru'] : $r['subject_title'];
	$subjects[$r['subject_code']] = $r['subject_code'] . " " . $tmp_title;
}

if ($mode == "add") {
	$sTTL = _ll('Добавить');
	$question['subject_code'] = $_POST['filter_subject'];
	$question['chapter_semester'] = $_POST['filter_semester'];
	$question['chapter_modul'] = $_POST['filter_module'];
}
if ($mode == "edit") {
	$sTTL = _ll('Редактировать');
	$question = $TS->question($id);
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">
	<input type="hidden" name="filter_dept" value="<?php echo $_POST['filter_dept']?>">
	<input type="hidden" name="filter_subject" value="<?php echo $_POST['filter_subject']?>">
	<input type="hidden" name="filter_semester" value="<?php echo $_POST['filter_semester']?>">
	<input type="hidden" name="filter_module" value="<?php echo $_POST['filter_module']?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php echo $sTTL?></h5>

		<div class="row mb-3">
			<label for="subject_code" class="col-sm-3 col-form-label text-end"><?php _l('Код предмета')?>:</label>
			<div class="col-sm-9">
				<select class="form-select" id="subject_code" name="subject_code" disabled="disabled">
					<option value="0"> -- <?php _l('Код предмета')?> -- </option>
					<?php echo getOptionsK($question['subject_code'], $subjects) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="chapter_code" class="col-sm-3 col-form-label text-end"><?php _l('Код главы')?>:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="chapter_code" name="chapter_code" value="<?php if (isset($question['chapter_code'])) echo $question['chapter_code']?>"  disabled="disabled">
			</div>
		</div>

		<div class="row mb-3">
			<label for="question_code" class="col-sm-3 col-form-label text-end"><?php _l('Код вопроса')?>:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="question_code" name="question_code" value="<?php if (isset($question['question_code'])) echo $question['question_code']?>"  disabled="disabled">
				<small>Subject.Semester.Module.Theme.Number.Type</small>
			</div>
		</div>

		<div class="row mb-3">
			<label for="question_ru" class="col-sm-3 col-form-label text-end">Вопрос:</label>
			<div class="col-sm-9">
			  <textarea class="form-control" id="question_title" name="question_ru"><?php if (isset($question['question_ru'])) echo $question['question_ru']?></textarea>
			</div>
		</div>
		<div class="row mb-3">
			<label for="question_title" class="col-sm-3 col-form-label text-end">Question:</label>
			<div class="col-sm-9">
			  <textarea class="form-control" id="question_title" name="question_title"><?php if (isset($question['question_title'])) echo $question['question_title']?></textarea>
			</div>
		</div>

		<div class="row mb-3">
			<label for="question_type" class="col-sm-3 col-form-label text-end"><?php _l('Тип вопроса');?>:</label>
			<div class="col-sm-9">
				<select class="form-select" id="question_type" name="question_type">
					<option value="0"> -- <?php _l('Тип вопроса')?> -- </option>
					<?php echo getOptions($question['question_type'], array("A","B","C")) ?>
				</select>
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