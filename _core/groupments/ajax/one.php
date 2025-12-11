<?php
require_once '../../../kernel.php';
$id = $_POST['pid'];
$mode = $_POST['mod'];

$plans = $DB->selectCol('SELECT plan_id AS ARRAY_KEY, plan_title FROM ?_3v_plans');
$semesters = $DB->selectCol('SELECT semester_id AS ARRAY_KEY, semester_title FROM ?_3v_semesters');

if ($mode == "add") {
	$sTTL = _ll('Добавить');
}
if ($mode == "edit") {
	$groupment = $TS->groupment($id);
	$sTTL = _ll('Редактировать');
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php echo $sTTL?></h5>

		<div class="row mb-3">
			<label for="grp_year" class="col-sm-3 col-form-label text-end"><?php _l('Уч. год') ?>:</label>
			<div class="col-sm-9">
				<select class="form-select" name="grp_year" id="grp_year">
					<?php if(empty($groupment['grp_year'])) { ?>
						<option value="">- <?php _l('Уч. год') ?> -</option>
					<?php } ?>
					<?php echo getOptions($groupment['grp_year'], year_entry())?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="plan_id" class="col-sm-3 col-form-label text-end"><?php _l('План') ?>:</label>
			<div class="col-sm-9">
				<select class="form-select" name="plan_id" id="plan_id">
					<?php if(empty($groupment['plan_id'])) { ?>
						<option value="">- <?php _l('План') ?> -</option>
					<?php } ?>
					<?php echo getOptionsK($groupment['plan_id'], $plans)?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="plan_id" class="col-sm-3 col-form-label text-end"><?php _l('Семестр')?>:</label>
			<div class="col-sm-9">
				<select class="form-select" name="semester_id" id="semester_id">
					<?php if(empty($groupment['semester_id'])) { ?>
						<option value="">- Select Semester -</option>
					<?php } ?>
					<?php echo getOptionsK($groupment['semester_id'], $semesters)?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="dept_title" class="col-sm-3 col-form-label text-end"><?php _l('Поток')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="dept_title" name="dept_title" value="<?php if (isset($groupment['dept_title'])) echo $groupment['dept_title']?>">
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