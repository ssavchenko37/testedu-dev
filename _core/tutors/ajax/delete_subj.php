<?php
require_once '../../../kernel.php';
$id = $_POST['pid'];
$mode = $_POST['mod'];

$t_s_id = $id;
$tutor_id = $DB->selectCell('SELECT tutor_id FROM ?_tutor_subjects WHERE t_s_id=?', $t_s_id);
$tutor = $TS->tutor($tutor_id);
$tutor_subject = $TS->tutorSubj($tutor_id, $t_s_id)[0];
$tutor_subj_groups = $DB->selectCol('SELECT G.grup_title FROM ?_tutor_groups TG INNER JOIN ?_groups G ON TG.grup_id=G.grup_id WHERE TG.t_s_id=?', $tutor_subject['t_s_id']);

// p($tutor['tutor']['tutor_fullname']);
// p($tutor['tutor']['tutor_fullru']);
// p($tutor_subject);
// p($tutor_subj_groups);

?>

<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="pid" value="<?php echo $tutor_id?>">
	<input type="hidden" name="t_s_id" value="<?php echo $t_s_id?>">
	<input type="hidden" name="mode" value="<?php echo $mode?>">


	<div class="col-sm-12 offset-md-1 col-md-10 col-lg-9 col-xl-8">
		<h4 class="mt-2 mb-5">
			<?php if ($lang == "ru") { ?>
				<p>Удалить связь Преподаватель / Дисциплина / Группы</p>
			<?php } else { ?>
				Delete link Tutor / Discipline / Groups
			<?php } ?>
		</h4>
		<div class="row mb-3">
			<div class="offset-sm-2 col-sm-10">
				<?php if ($lang == "ru") { ?>
					Внимание! Вы уверены, что хотите удалить связь Преподаватель / Дисциплина / Группы?
				<?php } else { ?>
					Warning! Are you sure you want to delete link Tutor / Discipline / Groups?
				<?php } ?>
			</div>
		</div>
		<div class="row mb-3">
			<div class="offset-sm-2 col-sm-10">
				<p class="mb-1"><?php _l('Преподаватель')?>:<strong> <?php echo _lt([$tutor['tutor']['tutor_fullru'],$tutor['tutor']['tutor_fullname']])?></strong></p>
				<p class="mb-1"><?php _l('Дисциплина')?>:<strong>
					<?php echo $tutor_subject['subject_code']?>
					<?php echo _lt([$tutor_subject['subject_ru'],$tutor_subject['subject_title']])?></strong>
				</p>
				<p><?php _l('Группы')?>:<strong>
					<?php echo implode('; ', $tutor_subj_groups);?>
				</p>
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