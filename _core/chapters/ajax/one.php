<?php
require_once '../../../kernel.php';
$id = $_POST['pid'];
$mode = $_POST['mod'];
// 

$modules = $DB->selectCol('SELECT DISTINCT chapter_modul AS ARRAY_KEY, chapter_modul FROM ?_3v_chapters'); 
$semesters = $DB->selectCol('SELECT semester_id AS ARRAY_KEY, semester_title FROM ?_3v_semesters');
$subjects = array();
$tmp = $DB->select('SELECT DISTINCT subject_code AS ARRAY_KEY, subject_code, subject_ru, subject_title'
	. ' FROM ?_3v_subjects'
	. ' WHERE subject_code IS NOT NULL'
	. ' {AND dept_code=?}'
	. ' ORDER BY subject_code'
	, empty($filter_dept) ? DBSIMPLE_SKIP : $filter_dept
);
foreach ($tmp as $r) {
	$tmp_title =  ($lang == "ru") ? $r['subject_ru'] : $r['subject_title'];
	$subjects[$r['subject_code']] = $r['subject_code'] . " " . $tmp_title;
}

if ($mode == "add") {
	$sTTL = _ll('Добавить');
	$chapter['subject_code'] = $_POST['filter_subject'];
	$chapter['chapter_semester'] = $_POST['filter_semester'];
	$chapter['chapter_modul'] = $_POST['filter_module'];
}
if ($mode == "edit") {
	$sTTL = _ll('Редактировать');
	$chapter = $TS->chapter($id);
	// p($chapter);
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" id="pid" value="<?php echo $id?>">
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
					<?php echo getOptionsK($chapter['subject_code'], $subjects) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="chapter_code" class="col-sm-3 col-form-label text-end"><?php _l('Код главы')?>:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="chapter_code" name="chapter_code" value="<?php if (isset($chapter['chapter_code'])) echo $chapter['chapter_code']?>"  disabled="disabled">
			</div>
		</div>

		<div class="row mb-3">
			<label for="semester_id" class="col-sm-3 col-form-label text-end"><?php _l('Cеместр')?>:</label>
			<div class="col-sm-9">
				<select class="form-select" id="semester_id" name="semester_id" disabled="disabled">
					<option value="0"> -- <?php _l('Cеместры')?> -- </option>
					<?php echo getOptionsK($chapter['chapter_semester'], $semesters) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="subject_code" class="col-sm-3 col-form-label text-end"><?php _l('Модуль') ?>:</label>
			<div class="col-sm-9">
				<select class="form-select" id="subject_code" name="subject_code" disabled="disabled">
					<option value="0"> -- <?php _l('Модуль')?> -- </option>
					<?php echo getOptionsK($chapter['chapter_modul'], array(1,2,3,4)) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="chapter_title" class="col-sm-3 col-form-label text-end"><?php _l('Глава')?>:</label>
			<div class="col-sm-9">
			  <textarea class="form-control" id="chapter_title" name="chapter_title"><?php if (isset($chapter['chapter_title'])) echo $chapter['chapter_title']?></textarea>
			</div>
		</div>

		<div class="row mb-3">
			<label for="chapter_num" class="col-sm-3 col-form-label text-end"><?php _l('Порядковый номер');?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="chapter_num" name="chapter_num" value="<?php if (isset($chapter['chapter_num'])) echo $chapter['chapter_num']?>" disabled="disabled">
			</div>
		</div>

		<div class="row mb-3">
			<label for="chapter_qst" class="col-sm-3 col-form-label text-end"><?php _l('Количество вопросов')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="chapter_qst" name="chapter_qst" value="<?php if (isset($chapter['chapter_qst'])) echo $chapter['chapter_qst']?>">
			</div>
		</div>

		<div class="row mb-3">
			<label for="chapter_a" class="col-sm-3 col-form-label text-end">Type A:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="chapter_a" name="chapter_a" value="<?php if (isset($chapter['chapter_a'])) echo $chapter['chapter_a']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="chapter_b" class="col-sm-3 col-form-label text-end">Type B:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="chapter_b" name="chapter_b" value="<?php if (isset($chapter['chapter_b'])) echo $chapter['chapter_b']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="chapter_c" class="col-sm-3 col-form-label text-end">Type C:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="chapter_c" name="chapter_c" value="<?php if (isset($chapter['chapter_c'])) echo $chapter['chapter_c']?>">
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