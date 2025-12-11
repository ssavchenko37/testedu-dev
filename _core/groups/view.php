<form method="post" id="frm0" name="forMain" enctype="multipart/form-data" onsubmit="return false">
	<input type="hidden" id="dept_id" name="dept_id" value="<?php echo $dept['dept_id']?>">
	<div class="row align-items-center">
		<div class="col-md-8">
			<h1><a href="/groupments/"><?php echo $dept['dept_title']?></a> / <?php _l("Группы")?></h1>
		</div>
		<div class="col-md-4 text-end ctrlBtn">
			<button class="btn btn-sm btn-main" type="button" data-mod="add" data-page="one"><i class="fa fa-plus" aria-hidden="true"></i> <?php _l('Добавить группу')?></button>
		</div>
	</div>
</form>

<table class="table table-striped table-hover border-secondary-subtle">
	<thead>
	<tr class="fixed-row sticky-top">
		<th class="w-10">&nbsp;</th>
		<th class="w-25"><?php _l('Группа')?></th>
		<th class="w-20"><?php _l('Студенты')?></th>
		<th class="w-15"><?php _l('Загрузить')?></th>
		<th class="w-20 text-right">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$q = 1;
    
	foreach ($groups as $r) {
		$tr_class = ($id == $r['grup_id']) ? "table-success": "";
		$request = $TS->request_encode('grpcode', $r['grup_id']);
		$std_qty = ($s_qty[$r['grup_id']] > 0) ? $s_qty[$r['grup_id']]: 0;
		?>
		<tr class="rws <?php echo $tr_class?>">
			<td>&nbsp;</td>
			<td class="align-middle"><?php echo $r['grup_title']?></td>
			<td class="align-middle">
				<a class="btn btn-sm btn-outline-secondary w-50" href="/students/?<?php echo $request?>" role="button">
					Students <span class="badge text-bg-secondary"><?php echo $std_qty?></span>
				</a>
			</td>
			<?php if ($tsdata['usr']['lvl'] == 1) { ?>
				<td class="align-middle">
					<div class="uploadBtn" data-pid="<?php echo $r['grup_id']?>">
						<button class="btn btn-sm btn-secondary" type="button">
							<i class="fas fa-upload"></i> Upload zip archive
						</button>
					</div>
				</td>
			<?php } ?>
			<td class="align-middle text-center">
				<div class="ctrlBtn" data-pid="<?php echo $r['grup_id']?>">
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