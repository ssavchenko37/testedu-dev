<?php
$id = $_POST['pid'];
$mode = $_POST['mod'];

$tutor = $TS->tutor($id)['tutor'];
$depts = $TS->tutorDept($id);
?>

<div class="row align-items-center">
	<div class="col-md-8">
		<h1><?php _l("Кафедры")?></h1>
		<h5><?php echo _lt([$tutor['tutor_fullru'],$tutor['tutor_fullname']])?></h5>
	</div>
	<div class="col-md-4 text-end ctrlBtn" data-pid="<?php echo $id?>">
		<button class="btn btn-sm btn-main" type="button" data-mod="add_dept" data-page="one_dept"><i class="fa fa-plus" aria-hidden="true"></i> <?php _l('Добавить кафедру')?></button>
	</div>
</div>

<table class="table table-striped table-hover border-secondary-subtle">
	<thead>
	<tr class="fixed-row sticky-top">
		<th class="w-15"><?php _l('Код')?></th>
		<th class="w-40"><?php _l('Кафедра')?></th>
		<th class="w-30"><?php _l('Тип')?></th>
		<th class="w-15 text-right">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$q = 1;
	foreach ($depts as $r) {
		?>
		<tr class="rws">
			<td class="align-middle"><small><?php echo $r['dept_code']?></small></td>
			<td class="align-middle" title="<?php echo $r['dept_id']?>">
				<?php echo _lt([$r['dept_ru'],$r['dept_title']])?>
			</td>
			<td class="align-middle"><?php echo $r['role_title']?></td>
			<td class="align-middle text-center">
				<div class="ctrlBtn" data-pid="<?php echo $r['t_d_id']?>">
					<button class="btn btn-success btn-sm" type="button" data-mod="edit_dept" data-page="one_dept"><i class="fas fa-pencil-alt"></i></button>
					<button class="btn btn-danger btn-sm" type="button" data-mod="delete_dept" data-page="delete_dept"><i class="far fa-trash-alt"></i></button>
				</div>
			</td>
		</tr>
		<?php
		$q++;
	}
	?>
	</tbody>
</table>