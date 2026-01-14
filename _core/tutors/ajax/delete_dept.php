<?php
$id = $_POST['pid'];
$mode = $_POST['mod'];

$t_d_id = $id;
$tutor_id = $DB->selectCell('SELECT tutor_id FROM ?_tutor_dept WHERE t_d_id=?', $t_d_id);
$tutor_dept = $TS->tutorDept($tutor_id, $t_d_id)[0];
?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $tutor_id?>">
	<input type="hidden" name="t_d_id" value="<?php echo $t_d_id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">


	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h4 class="mt-2 mb-5">
			<?php if ($lang == "ru") { ?>
				Удалить связь Преподаватель / Кафедра
			<?php } else { ?>
				Delete link Tutor / Department
			<?php } ?>
			
		</h4>
		<div class="row mb-3">
			<div class="offset-sm-3 col-sm-9 d-flex justify-content-between">
				<?php if ($lang == "ru") { ?>
					Внимание! Вы уверены, что хотите удалить связь Преподаватель / Кафедра?
				<?php } else { ?>
					Warning! Are you sure you want to delete link Tutor / Department?
				<?php } ?>
			</div>
		</div>

		<div class="row mb-3">
			<div class="offset-sm-3 col-sm-9 d-flex justify-content-between">
				<button class="btn btn-secondary dismiss-tsaside" type="button" aria-label="Close"> <?php _l('Отменить, не удалять')?> </button>
				<button type="submit" class="btn btn-main w-50"> <?php _l('Да, удалить')?> </button>
			</div>
		</div>
		
	</div>
</form>