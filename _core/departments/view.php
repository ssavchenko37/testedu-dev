<form method="post" id="frm0" name="forMain" enctype="multipart/form-data" onsubmit="return false">
	<div class="row align-items-center">
		<div class="col-md-8">
			<h1><?php _l("Кафедры")?></h1>
		</div>
		<div class="col-md-4 text-end ctrlBtn">
			<button class="btn btn-sm btn-main" type="button" data-mod="add" data-page="one"><i class="fa fa-plus" aria-hidden="true"></i> <?php _l('Добавить кафедру')?></button>
		</div>
	</div>
</form>

<table class="table table-striped table-hover border-secondary-subtle">
	<thead>
	<tr class="fixed-row sticky-top">
		<th class="w-10"><?php _l('Код')?></th>
		<th class="w-40"><?php _l('Кафедра')?></th>
		<th class="w-20"><?php _l('Предметы')?></th>
		<th class="w-20"><?php _l('Преподаватели')?></th>
		<th class="w-10 text-right">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$q = 1;
    
	foreach ($departments as $r) {
		$tr_class = ($id == $r['dept_id']) ? "table-success": "";
		$totalSubjects = ($dept_subjects[$r['dept_code']]['qty'] > 0) ? $dept_subjects[$r['dept_code']]['qty']: 0;
		$totalTutors = ($dept_tutors[$r['dept_id']]['qty'] > 0) ? $dept_tutors[$r['dept_id']]['qty']: 0;
		$request = $TS->request_encode('dcode', $r['dept_code']);
		?>
		<tr class="rws <?php echo $tr_class?>">
			<td class="align-middle"><?php echo $r['dept_code']?></td>
			<td class="align-middle">
				<?php echo $r['dept_ru']?><br><small><?php echo $r['dept_title']?></small>
			</td>
			<td class="align-middle">
				<a class="btn btn-sm btn-outline-secondary" href="/subjects/?<?php echo $request?>" role="button">
					<?php _l('Предметы')?> <span class="badge text-bg-secondary"><?php echo $totalSubjects?></span>
				</a>
			</td>
			<td class="align-middle">
				<a class="btn btn-sm btn-outline-secondary" href="/tutors/?<?php echo $request?>" role="button">
					<?php _l('Преподаватели')?> <span class="badge text-bg-secondary"><?php echo $totalTutors?></span>
				</a>
			</td>
			<td class="align-middle text-center">
				<div class="ctrlBtn" data-pid="<?php echo $r['dept_id']?>">
					<button class="btn btn-success btn-sm" type="button" data-mod="edit" data-page="one"><i class="fas fa-pencil-alt"></i></button>
					<button class="btn btn-danger btn-sm" type="button" data-mod="delete" data-page="delete"><i class="far fa-trash-alt"></i></button>
				</div>
			</td>
		</tr>
		<?php
		$q++;
	}
	?>
	</tbody>
</table>

<div class="offcanvas offcanvas-end viewer" tabindex="-1" id="detailsOne" aria-labelledby="detailsOneLabel">
	<div class="offcanvas-header">
		<div class="viewer__close">
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
	</div>
	<div class="offcanvas-body" id="offcanvas_body">
		
	</div>
</div>