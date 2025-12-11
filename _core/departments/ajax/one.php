<?php
require_once '../../../kernel.php';
$id = $_POST['pid'];
$mode = $_POST['mod'];

if ($mode == "add") {
	$sTTL = _ll('Добавить');
}
if ($mode == "edit") {
	$department = $TS->department($id);
	$sTTL = _ll('Редактировать');
}
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">

	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h5 class="mt-2 mb-5"><?php echo $sTTL?></h5>

		<div class="row mb-3">
			<label for="dept_code" class="col-sm-3 col-form-label text-end"><?php _l('Код') ?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="dept_code	" name="dept_code" value="<?php if (isset($department['dept_code'])) echo $department['dept_code']?>">
			</div>
		</div>

		<div class="row mb-3">
			<label for="dept_ru" class="col-sm-3 col-form-label text-end">Кафедра:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="dept_ru" name="dept_ru" value="<?php if (isset($department['dept_ru'])) echo $department['dept_ru']?>">
			</div>
		</div>

		<div class="row mb-3">
			<label for="dept_title" class="col-sm-3 col-form-label text-end">Department:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="dept_title" name="dept_title" value="<?php if (isset($department['dept_title'])) echo $department['dept_title']?>">
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