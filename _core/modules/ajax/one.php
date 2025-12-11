<?php
require_once '../../../kernel.php';
$tsdata = $TS->tsdata();
$id = $_POST['pid'];
$mode = $_POST['mod'];
$tutor_id = 0;
p($_POST);
if ($tsdata['umod'] == "a") {
	$tmp = $DB->select('SELECT * FROM ?_3v_modules');
	$tutors_name = ($lang == "ru") 
		? $DB->selectCol('SELECT tutor_id AS ARRAY_KEY, CONCAT(tutor_id, ") ", tutor_fullru) FROM ?_tutor ORDER BY tutor_fullru')
		: $DB->selectCol('SELECT tutor_id AS ARRAY_KEY, CONCAT(tutor_id, ") ", tutor_fullname) FROM ?_tutor ORDER BY tutor_fullname')
	;
	foreach ($tmp as $r) {
		$tutors[$r['tutor_id']] = $tutors_name[$r['tutor_id']];
	}
}
if ($tsdata['umod'] == "t") {
	$tutor_id = $tsdata['usr']['tutor_id'];
	$tutors[$tutor_id] = ($lang == "ru") ? $tsdata['usr']['tutor_fullru']: $tsdata['usr']['tutor_fullname'];
}

if ($mode == "add") {
	$sTTL = _ll('Добавить');
	$module['sDate'] = date('Y-m-d');
	$module['sTime'] = "10:00";
	$module['tutor_id'] = $tsdata['id'];
}
if ($mode == "edit") {
	$sTTL = _ll('Редактировать');
	$module = $DB->selectRow('SELECT *'
		. ', DATE_FORMAT(module_date, \'%Y-%m-%d\') as sDate'
		. ', DATE_FORMAT(module_date, \'%H:%i:%s\') as sTime'
		. ' FROM ?_3v_modules'
		. ' WHERE module_id=?'
		, $id
	);
}

?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" id="pid" value="<?php echo $id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">
	<input type="hidden" name="tutor_id" value="<?php echo $tutor_id?>">
	<input type="hidden" name="filter_dept" value="<?php echo $data['filter_dept']?>">
	<input type="hidden" name="filter_subject" value="<?php echo $data['filter_subject']?>">
	<input type="hidden" name="filter_sem" value="<?php echo $data['filter_sem']?>">
	<input type="hidden" name="filter_mdl" value="<?php echo $data['filter_mdl']?>">
    <input type="hidden" name="filter_tutor" value="<?php echo $data['filter_tutor']?>">
	<input type="hidden" name="filter_daterange" value="<?php echo $data['filter_daterange']?>">
	<input type="hidden" name="filter_status" value="<?php echo $data['filter_status']?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php echo $sTTL?></h5>

		<div class="row mb-3">
			<label for="tutor_id" class="col-sm-3 col-form-label text-end"><?php _l('Преподаватель')?>:</label>
			<div class="col-sm-9">
				<select class="form-select" id="tutor_id" name="tutor_id">
					<?php if ($tsdata['umod'] == "a") { ?>
						<option value="0"> -- <?php _l('Преподаватель')?> -- </option>
					<?php } ?>
					<?php echo getOptionsK($module['tutor_id'], $tutors); ?>
				</select>
			</div>
		</div>
		<div class="row mb-3">
			<label for="module_date" class="col-sm-3 col-form-label text-end"><?php _l('Дата модуля')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="module_date" name="module_date" value="<?php if (isset($module['module_date'])) echo $module['module_date']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="module_duration" class="col-sm-3 col-form-label text-end"><?php _l('Продолжительность')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="module_duration" name="module_duration" value="<?php if (isset($module['module_duration'])) echo $module['module_duration']?>" placeholder="45">
			  <small class="text-secondary"><?php _l('Продолжительность модуля в минутах')?></small>
			</div>
		</div>
		<div class="row mb-3">
			<label for="module_desc" class="col-sm-3 col-form-label text-end"><?php _l('Описание')?>:</label>
			<div class="col-md-9">
				<textarea class="form-control" id="module_desc" name="module_desc"><?php if (isset($module['module_desc'])) echo $module['module_desc']?></textarea>
			</div>
		</div>
		<div class="row mb-3">
			<label for="module_subject" class="col-md-3 col-form-label text-end"> <?php _l('Предмет')?>: </label>
			<div class="col-md-9">
				<select class="form-select" id="module_subject" name="module_subject">
				</select>
			</div>
		</div>
		<div class="row mb-3">
			<label for="module_semester" class="col-md-3 col-form-label text-end"> <?php _l('Семестр')?>: </label>
			<div class="col-md-9">
				<select class="form-select" id="module_semester" name="module_semester">
				</select>
			</div>
		</div>
		<div class="row mb-3">
			<label for="module_num" class="col-md-3 col-form-label text-end"> <?php _l('Модуль')?>: </label>
			<div class="col-md-9">
				<select class="form-select" id="module_num" name="module_num">
				</select>
			</div>
		</div>
		<div class="row mb-3">
			<label for="module_groups" class="col-md-3 col-form-label text-end"> <?php _l('Группы')?>: </label>
			<div class="col-md-9">
				<select class="form-control form-control-sm" multiple="" size="5" id="module_groups" name="grup_ids[]">
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