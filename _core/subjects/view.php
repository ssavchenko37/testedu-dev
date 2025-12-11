<form action="/subjects/" method="post" id="frm0" name="forMain">
	<div class="row align-items-center">
		<div class="col-md-8">
			<h1><?php _l("Предметы")?></h1>
		</div>
		<div class="col-md-4 text-end ctrlBtn">
			<button class="btn btn-sm btn-main" type="button" data-mod="add" data-page="one"><i class="fa fa-plus" aria-hidden="true"></i> <?php _l('Добавить предмет')?></button>
		</div>
	</div>

	<div class="card border border-secondary-subtle">
		<div class="card-header py-2 bg-light border-bottom border-secondary-subtle">
			<div class="row">
				<div class="col-sm-5 d-flex">
					<label for="schstr" class="col-form-label col-form-label-sm pe-3"><?php _l('Поиск')?>: </label>
					<div class="input-group input-group-sm">
						<input type="text" class="form-control form-control-sm" id="schstr" name="schstr"
							   value="<?php if( !empty($schstr) ) echo $schstr;?>" placeholder="<?php _l('Поиск по предмету или коду')?>"/>
						<button class="btn btn-sm btn-secondary" type="submit" id="btn_schstr"> <?php _l('Поиск')?> </button>
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
							<label for="filter_plan" class="form-label form-label-sm"><?php _l('Планы')?>: </label>
							<select class="form-select form-select-sm" id="filter_plan" name="filter_plan">
								<option value="0"> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_plan, $plans) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_code" class="form-label form-label-sm"><?php _l('Кафедра')?>: </label>
							<select class="form-select form-select-sm" id="filter_code" name="filter_code">
								<option value="0"> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_code, $departments) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_semester" class="form-label form-label-sm"><?php _l('Cеместр')?>: </label>
							<select class="form-select form-select-sm" id="filter_semester" name="filter_semester">
								<option value="0"> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_semester, $semesters) ?>
                            
							</select>
						</div>
					</div>             
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_exams" class="form-label form-label-sm"><?php _l('Экзамен')?>: </label>
							<select class="form-select form-select-sm" id="filter_exams" name="filter_exams">
								<option value="0"> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_exams, array(1=>"Yes", 2=>"No")); ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-sm-4">
						<button type="submit" class="btn btn-sm btn-main">
							<?php _l('Применить')?>&nbsp;<?php echo mb_strtolower(_ll('Фильтры'))?>
						</button>
					</div>
					<div class="col-sm-4 text-center">
						<a href="/subjects/" class="btn btn-sm btn-info">
							<?php _l('Очистить')?>
						</a>
					</div>
					<div class="col-sm-4 text-end">
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
		<th class="w-10"><?php _l('План')?></th>
		<th class="w-10"><?php _l('Cеместр')?></th>
		<th class="w-10"><?php _l('Код')?></th>
		<th class="w-30"><?php _l('Предмет')?></th>
		<th><?php _l('Кредиты')?></th>
		<th><?php _l('Экзамен')?></th>
		<th class="w-15"><?php _l('Главы')?></th>
		<th class="w-10 text-right">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$q = 1;
    
	foreach ($subjects as $r) {
		$tr_class = ($id == $r['subject_id']) ? "table-success": "";
		$request = $TS->request_encode('scode', $r['subject_code']);
		?>
		<tr class="rws <?php echo $tr_class?>">
			<td class="align-middle"><?php echo $r['plan_year']?></td>
			<td class="align-middle"><?php echo $r['semester_title']?></td>
			<td class="align-middle"><?php echo $r['subject_code']?></td>
			<td class="align-middle"><?php echo $r['subject_ru']?><br><small><?php echo $r['subject_title']?></small></td>
			<td class="align-middle"><?php echo $r['subject_credits']?></td>
			<td class="align-middle"><?php echo $r['has_exam']?></td>
			<td class="align-middle">
				<a class="btn btn-sm btn-outline-secondary <?php if (empty($chaptersV3[$r['subject_code']]))  echo "disabled"?>" href="/chapters/?<?php echo $request?>" role="button">
					<?php _l('Главы')?> <span class="badge text-bg-secondary"><?php echo (empty($chaptersV3[$r['subject_code']])) ? 0 : $chaptersV3[$r['subject_code']]?></span>
				</a>
			</td>
			<td class="align-middle text-center">
				<div class="ctrlBtn" data-pid="<?php echo $r['subject_id']?>">
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