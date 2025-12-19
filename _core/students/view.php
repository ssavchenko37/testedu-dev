<form method="post" id="frm0" name="forMain" enctype="multipart/form-data" onsubmit="return false">
	<input type="hidden" id="grup_id" name="grup_id" value="<?php echo $group['grup_id']?>">
	<div class="row align-items-center">
		<div class="col-md-8">
			<h1><?php _l("Студенты")?></h1>
			<h5><a href="/groupments/"><?php echo $groupment['dept_title']?></a> / <a href="/groups/?<?php echo $request_dept_id?>"><?php echo $group['grup_title']?></a></h5>
		</div>
		<div class="col-md-4 text-end ctrlBtn">
			<button class="btn btn-sm btn-main" type="button" data-mod="add" data-page="one"><i class="fa fa-plus" aria-hidden="true"></i> <?php _l('Добавить студена')?></button>
		</div>
	</div>
</form>

<table class="table table-striped table-hover border-secondary-subtle">
	<thead>
	<tr class="fixed-row sticky-top">
		<th class="w-5">#</th>
		<th class="w-10">Photo</th>
		<th class="w-35">Name</th>
		<th class="w-20">Record book</th>
		<th class="w-10">Account</th>
		<th class="w-10">Status</th>
		<th class="w-20 text-right">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$q = 1;
	foreach ($students as $r) {
		$tr_class = ($id == $r['stud_id']) ? "table-success": "default";
		$stud_status = "<span class='text-success'>Active</span>";
		$stud_status = ( $r['stud_status'] == 1 ) ? "<span class='text-info'>Test mode</span>": $stud_status;
		$stud_status = ( $r['stud_status'] == 2 ) ? "<span class='text-danger'>Blocked</span>": $stud_status;
		$is_account = ( empty($r['stud_pass']) )
			? "<span class='text-muted p-1'>No</span>"
			: "<span class='bg-success py-1 px-2 rounded text-white'>Yes</span>"
		;
		$ava = '';
		if (is_file(S_AVA . DIRECTORY_SEPARATOR . $r['stud_pic'])) {
			$ava = DIRECTORY_SEPARATOR . S_AVA . DIRECTORY_SEPARATOR . $r['stud_pic'];	
		}
		?>
		<tr class="rws <?php echo $tr_class?>">
			<td class="align-middle"><?php echo $q?></td>
			<td class="align-middle"><img class="stud-pic" src="<?php echo $ava?>" alt="No ava"></td>
			<td class="align-middle"><?php echo _ls($r['stud_name'])?><br></td>
			<td class="align-middle"><?php echo $r['record_book']?></td>
			<td class="align-middle"><?php echo $is_account?></td>
			<td class="align-middle"><?php echo $stud_status?></td>
			<td class="align-middle text-center">
				<div class="ctrlBtn" data-pid="<?php echo $r['stud_id']?>">
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
