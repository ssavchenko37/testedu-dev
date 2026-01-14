<?php
$id = $_POST['pid'];
$mode = $_POST['mod'];

if ($mode == "edit_dept") {
	$t_d_id = $id;
	$tutor_id = $DB->selectCell('SELECT tutor_id FROM ?_tutor_dept WHERE t_d_id=?', $t_d_id);
	$tutor_dept = $TS->tutorDept($tutor_id, $t_d_id)[0];
} else {
	$t_d_id = "";
	$tutor_id = $id;
	$tutor_dept = array();
}
$tutor = $TS->tutor($tutor_id)['tutor'];
$roles = $DB->selectCol('SELECT role_id AS ARRAY_KEY, role_title FROM ?_roles ORDER BY role_ord');
if ($lang == "ru") {
	$departments = $DB->selectCol('SELECT dept_id AS ARRAY_KEY, CONCAT(dept_code, ") ", dept_ru) AS title FROM ?_departments ORDER BY dept_code + 1');
} else {
	$departments = $DB->selectCol('SELECT dept_id AS ARRAY_KEY, CONCAT(dept_code, ") ", dept_ru) AS title FROM ?_departments ORDER BY dept_code + 1');
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $tutor_id?>">
	<input type="hidden" name="t_d_id" value="<?php echo $t_d_id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php _l('Преподаватель')?> <?php echo _lt([$tutor['tutor_fullru'], $tutor['tutor_fullname']])?></h5>

		<div class="row mb-3">
			<label for="dept_id" class="col-sm-3 col-form-label text-end"><?php _l('Кафедра')?>:</label>
			<div class="col-sm-9">
				<select class="form-control" id="dept_id" name="dept_id">
					<option value="0"> -- <?php _l('Кафедра')?> -- </option>
					<?php echo getOptionsK($tutor_dept['dept_id'], $departments) ?>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="role_id" class="col-sm-3 col-form-label text-end"><?php _l('Роль')?>:</label>
			<div class="col-sm-9">
				<select class="form-control" id="role_id" name="role_id">
					<option value="0"> -- <?php _l('Роль')?> -- </option>
					<?php echo getOptionsK($tutor_dept['role_id'], $roles) ?>
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