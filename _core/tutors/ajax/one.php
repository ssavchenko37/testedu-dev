<?php
require_once '../../../kernel.php';
$id = $_POST['pid'];
$mode = $_POST['mod'];

$tutor = array();
$role = $DB->selectCol('SELECT role_id AS ARRAY_KEY, role_title FROM ?_roles');
$ava = DIRECTORY_SEPARATOR . S_AVA . DIRECTORY_SEPARATOR . "no-ava.png";
if ($mode == "add") {
	$sTTL = _ll('Добавить');
}
if ($mode == "edit") {
	$tutor = $TS->tutor($id)['tutor'];
	$tutor['tmp_fullname'] = trim($tutor['tutor_lastname'] . " " . $tutor['tutor_name'] . " " . $tutor['tutor_patronymic']);
	$sTTL = _ll('Редактировать');
	
	if (is_file("../../../" . S_AVA . DIRECTORY_SEPARATOR . $tutor['ava_img'])) {
		$ava = DIRECTORY_SEPARATOR . S_AVA . DIRECTORY_SEPARATOR . $tutor['ava_img'];	
	}
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php echo $sTTL?></h5>

		<div class="row mb-3">
			<label for="tmp_fullname" class="col-sm-3 col-form-label text-end"><?php _l('Полное имя')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="tmp_fullname" name="tmp_fullname" value="<?php if (isset($tutor['tmp_fullname'])) echo $tutor['tmp_fullname']?>" placeholder="Фамилия Имя Отчество">
			</div>
		</div>
		
		<div class="row mb-3">
			<label for="tutor_fullru" class="col-sm-3 col-form-label text-end">Фамилия И.О.:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="tutor_fullru" name="tutor_fullru" value="<?php if (isset($tutor['tutor_fullru'])) echo $tutor['tutor_fullru']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="tutor_fullname" class="col-sm-3 col-form-label text-end">Name:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="tutor_fullname" name="tutor_fullname" value="<?php if (isset($tutor['tutor_fullname'])) echo $tutor['tutor_fullname']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="assistant" class="col-sm-3 col-form-label text-end"><?php _l('Ассистент')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="assistant" name="assistant" value="<?php if (isset($tutor['assistant'])) echo $tutor['assistant']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="tutor_uin" class="col-sm-3 col-form-label text-end">UIN:</label>
			<div class="col-sm-9">
				<input type="text" class="form-control" id="tutor_uin" name="tutor_uin" value="<?php if (isset($tutor['tutor_uin'])) echo $tutor['tutor_uin']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="tutor_email" class="col-sm-3 col-form-label text-end"><?php _l('Электронная почта')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="tutor_email" name="tutor_email" value="<?php if (isset($tutor['tutor_email'])) echo $tutor['tutor_email']?>">
			</div>
		</div>
		<div class="row mb-3">
			<label for="tutor_pass" class="col-sm-3 col-form-label text-end"><?php _l('Пароль')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="tutor_pass" name="tutor_pass" value="<?php if (isset($tutor['tutor_pass'])) echo $tutor['tutor_pass']?>">
			</div>
		</div>
		<div class="row mb-3 ava">
			<label for="ava_img" class="col-sm-3 col-form-label text-end"><?php _l('Изображение')?>:</label>
			<div class="col ava__image">
				<img src="<?php echo $ava?>" alt="<?php if (isset($tutor['tutor_fullru'])) echo $tutor['tutor_fullru']?>">
			</div>
			<div class="col-sm-7 ava__file">
				<input class="form-control " type="file" name="ava_img" id="ava_img">
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