<?php
require_once '../../../kernel.php';
$id = $_POST['pid'];
$mode = $_POST['mod'];
$grup_id = $_POST['grup_id'];

$group = $TS->group($grup_id);
$groupment = $TS->groupment($group['dept_id']);
// $groupments = $DB->select('SELECT * FROM ?_groupments ORDER BY semester_id');
// $groups = $DB->select('SELECT * FROM ?_groups ORDER BY dept_id=?', $group['dept_id']);

$student = array();

$ava = DIRECTORY_SEPARATOR . S_AVA . DIRECTORY_SEPARATOR . "no-ava.png";
if ($mode == "add") {
	$sTTL = _ll('Добавить');
}
if ($mode == "edit") {
	$student = $TS->student($id);
	$sTTL = _ll('Редактировать');
	if (is_file("../../../" . S_AVA . DIRECTORY_SEPARATOR . $student['stud_pic'])) {
		$ava = DIRECTORY_SEPARATOR . S_AVA . DIRECTORY_SEPARATOR . $student['stud_pic'];
	}
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php echo $sTTL?></h5>

		<div class="row mb-3">
			<label for="dept_id" class="col-sm-3 col-form-label text-end"><?php _l('Поток') ?>:</label>
			<div class="col-sm-9">
				<select class="form-select" name="dept_id" id="dept_id">
					<?php if(empty($group['grup_id'])) { ?>
						<option value="">- <?php _l('Поток') ?> -</option>
					<?php } ?>
					<option value="<?php echo $groupment['dept_id']?>"><?php echo $groupment['dept_title']?></option>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="grup_id" class="col-sm-3 col-form-label text-end"><?php _l('Группа') ?>:</label>
			<div class="col-sm-9">
				<select class="form-select" name="grup_id" id="grup_id">
					<?php if(empty($group['grup_id'])) { ?>
						<option value="">- <?php _l('Группа') ?> -</option>
					<?php } ?>
					<option value="<?php echo $group['grup_id']?>"><?php echo $group['grup_title']?></option>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="stud_ru" class="col-sm-3 col-form-label text-end">Фамилия И.О.:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="stud_ru" name="stud_ru" value="<?php if (isset($student['stud_ru'])) echo $student['stud_ru']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="stud_name" class="col-sm-3 col-form-label text-end">Name:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="stud_name" name="stud_name" value="<?php if (isset($student['stud_name'])) echo $student['stud_name']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="record_book" class="col-sm-3 col-form-label text-end"><?php _l('Зачетная книжка')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="record_book" name="record_book" value="<?php if (isset($student['record_book'])) echo $student['record_book']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="stud_uin" class="col-sm-3 col-form-label text-end">Nickname:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="stud_uin" name="stud_uin" value="<?php if (isset($student['stud_uin'])) echo $student['stud_uin']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="stud_email" class="col-sm-3 col-form-label text-end"><?php _l('Электронная почта')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="stud_email" name="stud_email" value="<?php if (isset($student['stud_email'])) echo $student['stud_email']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="new_stud_pass" class="col-sm-3 col-form-label text-end"><?php _l('Пароль')?>:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="new_stud_pass" name="new_stud_pass" value="<?php if (isset($student['new_stud_pass'])) echo $student['new_stud_pass']?>">
				<?php if ($lang == "ru") { ?>
					<small class="text-body-secondary"> Установите новый пароль, если с вами свяжется студент, который потерял <span title="<?php echo $student['stud_pass']?>">пароль</span>.</small>	
				<?php } else { ?>
					<small class="text-body-secondary"> Set a new password if you are contacted by a student who has lost a <span title="<?php echo $student['stud_pass']?>">password</span>.</small>
				<?php } ?>			
			</div>
		</div>
		<div class="row mb-3 ava">
			<label for="stud_pic" class="col-sm-3 col-form-label text-end"><?php _l('Изображение')?>:</label>
			<div class="col ava__image">
				<img src="<?php echo $ava?>" alt="<?php if (isset($student['stud_pic'])) echo $student['stud_pic']?>">
			</div>
			<div class="col-sm-7 ava__file">
				<input class="form-control " type="file" name="stud_pic" id="stud_pic">
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