<form method="post" id="frm0" name="forMain" enctype="multipart/form-data" onsubmit="return false">
	<div class="row align-items-center">
		<div class="col-md-8">
			<h1><?php _l("Отработки")?></h1>
		</div>
	</div>

	<div class="card border border-secondary-subtle">
		<div class="card-header py-2 bg-light border-bottom border-secondary-subtle">
			<div class="row">
				<div class="col-sm-5 d-flex">
					<label for="schstr" class="col-form-label col-form-label-sm pe-3"><?php _l('Поиск')?>: </label>
					<div class="input-group input-group-sm">
						<input type="text" class="form-control form-control-sm" id="schstr" name="schstr"
							   value="<?php if( !empty($schstr) ) echo $schstr;?>" placeholder="search by Student name"/>
						<button class="btn btn-sm btn-secondary" type="button" id="btn_schstr"> <?php _l('Поиск')?> </button>
					</div>
				</div>
				<div class="col-sm-3">
					<button class="btn btn-sm btn-secondary" type="button" data-bs-toggle="collapse" href="#collapseCBody" role="button" aria-expanded="false" aria-controls="collapseCBody">
						<?php _l('Фильтры')?>
					</button>
				</div>
			</div>
		</div>
		<div class="collapse show" id="collapseCBody">
			<div class="card-body py-3">
				<div class="close-abs">
					<button type="button" class="btn-close close-card-body" data-bs-toggle="collapse" href="#collapseCBody" role="button" aria-expanded="false" aria-controls="collapseCBody"></button>
				</div>
				
				<div class="row">
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_tutor" class="form-label form-label"><?php _l('Преподаватель')?>: </label>
							<select class="form-control form-control-sm" id="filter_tutor" name="filter_tutor">
								<option value="0"><?php _l('Просмотреть все')?></option>
								<?php echo getOptionsK($filter_tutor, $filter_tutors) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_grm" class="form-label form-label-sm"><?php _l('Поток')?>: </label>
							<select class="form-control form-control-sm" id="filter_grm" name="filter_grm">
								<option value="0"><?php _l('Просмотреть все')?></option>
								<?php echo getOptionsK($filter_grm, $filter_groupments) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_grup" class="form-label form-label-sm"><?php _l('Группа')?>: </label>
							<select class="form-control form-control-sm" id="filter_grup" name="filter_grup">
								<option value="0"><?php _l('Просмотреть все')?></option>
								<?php echo getOptionsK($filter_grup, $filter_groups) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_subject" class="form-label form-label-sm"><?php _l('Предмет')?>: </label>
							<select class="form-control form-control-sm" id="filter_subject" name="filter_subject">
								<option value="0"><?php _l('Просмотреть все')?></option>
								<?php echo getOptionsK($filter_subject, $filter_subjects) ?>
							</select>
						</div>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-sm-6">
						<a href="/makeups/" class="btn btn-sm btn-info"> <?php _l('Очистить')?></a>
					</div>
					<div class="col-sm-6 text-end">
						<button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="collapse" href="#collapseCBody" role="button" aria-expanded="false" aria-controls="collapseCBody">
							<?php _l('Закрыть')?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<br>
<table class="table table-striped table-hover border-secondary-subtle">
	<thead>
	<tr class="fixed-row sticky-top">
		<th class="w-5">#</th>
		<th class="w-10"><?php _l('Период')?></th>
		<th class="w-20"><?php _l('Преподаватель')?></th>
		<th class="w-10"><?php _l('Группа')?></th>
		<th class="w-40"><?php _l('Предмет')?></th>
		<th class="w-15"><?php _l('Действия')?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$q = 1;
	foreach ($absents as $r) {
		$tr_class = ($id == $r['ibook_id']) ? "table-success": "";
		$request = $TS->request_encode('ibcode', $r['ibook_id']);
		?>
		<tr class="rws <?php echo $tr_class?>">
			<td class="align-middle"><?php echo $r['ibook_id']?></td>
			<td class="align-middle"><?php echo $r['sheet_period']?></td>
			<td class="align-middle"><?php echo $filter_tutors[$r['tutor_id']]?></td>
			<td class="align-middle"><?php echo $r['grup_title']?></td>
			<td class="align-middle"><?php echo $filter_subjects[$r['subject_id']]?></td>
			<td class="align-middle text-center">
				<a class="get_details btn btn-success btn-sm" role="button" href="/makeup/?<?php echo $request?>"><i class="fa-solid fa-book-open"></i></a>
			</td>
		</tr>
		<?php
		$q++;
	}
	?>
	</tbody>
</table>