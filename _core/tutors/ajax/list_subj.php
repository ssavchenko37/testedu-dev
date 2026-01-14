<?php
$id = $_POST['pid'];
$mode = $_POST['mod'];

$tutor = $TS->tutor($id)['tutor'];
$subjs = $TS->tutorSubj($id);
$sids = $grps = [];
foreach ($subjs as $s) {
	$sids[] = $s['t_s_id'];
}
if (count($sids) > 0) {
	$tmp = $DB->select('SELECT TG.*, G.grup_title FROM ?_tutor_groups TG INNER JOIN ?_groups G ON TG.grup_id=G.grup_id WHERE TG.t_s_id IN(?a)', $sids);
	$grps = [];
	foreach ($tmp as $r) {
		$grps[$r['t_s_id']][$r['t_g_id']] = $r['grup_title'];
	}
}

?>

<div class="row align-items-center">
	<div class="col-md-8">
		<h1><?php _l("Предметы")?></h1>
		<h5><?php echo _lt([$tutor['tutor_fullru'],$tutor['tutor_fullname']])?></h5>
	</div>
	<div class="col-md-4 text-end ctrlBtn" data-pid="<?php echo $id?>">
		<button class="btn btn-sm btn-main" type="button" data-mod="add_subj" data-page="one_subj"><i class="fa fa-plus" aria-hidden="true"></i> <?php _l('Добавить предмет')?></button>
	</div>
</div>

<table class="table table-striped table-hover border-secondary-subtle">
	<thead>
	<tr class="fixed-row sticky-top">
		<th class="w-25"><?php _l('Кафедра')?></th>
		<th class="w-5"><?php _l('Тип')?></th>
		<th class="w-25"><?php _l('Предмет')?></th>
		<th class="w-35"><?php _l('Группы')?></th>
		<th class="w-10 text-right">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$q = 1;
	foreach ($subjs as $r) {
		$stype = ($r['stype'] == "lc") 
			? _ll('Лекция')
			: _ll('Практика')
		;
		?>
		<tr class="rws">
			<td class="align-middle" title="<?php echo $r['dept_id']?>">
				<small><?php echo $r['dept_code']?></small>
				<?php echo _lt([$r['dept_ru'],$r['dept_title']])?>
			</td>
			<td class="align-middle">
				<?php echo $stype?>
			</td>
			<td class="align-middle">
				<?php echo _lt([$r['subject_ru'],$r['subject_en']])?><br>
				<small><?php echo $r['subject_code']?> / <?php echo _lt([$r['plan_sem_ru'],$r['plan_sem_en']])?><small>
			</td>
			<td class="align-middle">
				<?php echo implode('; ', $grps[$r['t_s_id']]);?>
			</td>
			<td class="align-middle text-center">
				<div class="ctrlBtn" data-pid="<?php echo $r['t_s_id']?>">
					<button class="btn btn-success btn-sm" type="button" data-mod="edit_subj" data-page="one_subj"><i class="fas fa-pencil-alt"></i></button>
					<button class="btn btn-danger btn-sm" type="button" data-mod="delete_subj" data-page="delete_subj"><i class="far fa-trash-alt"></i></button>
				</div>
			</td>
		</tr>
		<?php
		$q++;
	}
	?>
	</tbody>
</table>