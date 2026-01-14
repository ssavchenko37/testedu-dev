<?php
$id = $_POST['pid'];
$mode = $_POST['mod'];
$dept_id = $_POST['dept_id'];

$dept = $DB->selectRow('SELECT * FROM ?_groupments WHERE dept_id=?', $dept_id);
$group = [];

if ($mode == "add") {
	$sTTL = _ll('Добавить');
}
if ($mode == "edit") {
	$group = $TS->group($id);
	$sTTL = _ll('Редактировать');
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
					<option value="<?php echo $dept['dept_id']?>"><?php echo $dept['dept_title']?></option>
				</select>
			</div>
		</div>

		<div class="row mb-3">
			<label for="grup_title" class="col-sm-3 col-form-label text-end"><?php _l('Группа')?>:</label>
			<div class="col-sm-9">
			  <input type="text" class="form-control" id="grup_title" name="grup_title" value="<?php if (isset($group['grup_title'])) echo $group['grup_title']?>">
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