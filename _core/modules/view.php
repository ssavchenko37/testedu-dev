<form action="/modules/" method="post" id="frm0" name="forMain">
	<div class="row align-items-center">
		<div class="col-md-8">
			<h1><?php _l("Модули")?></h1>
		</div>
		<div class="col-md-4 text-end ctrlBtn">
			<button class="btn btn-sm btn-main" type="button" data-mod="add" data-page="one"><i class="fa fa-plus" aria-hidden="true"></i> <?php _l('Добавить модуль')?></button>
		</div>
	</div>

	<div class="card border border-secondary-subtle">
		<div class="card-header py-2 bg-light border-bottom border-secondary-subtle">
			<div class="row">
				<div class="col-sm-5 d-flex">
					<label for="schstr" class="col-form-label col-form-label-sm pe-3"><?php _l('Поиск')?>: </label>
					<div class="input-group input-group-sm">
						<?php
						$search_by_str = [
							"Поиск по предмету, коду или преподавателю",
							"Search by subject, code, or teacher"
						];
						?>
						<input type="text" class="form-control form-control-sm" id="schstr" name="schstr"
							   value="<?php if( !empty($schstr) ) echo $schstr;?>" placeholder="<?php echo _lt($search_by_str)?>"/>
						<button class="btn btn-sm btn-secondary" type="submit" name="filter_action" value="apply_filters"> <?php _l('Поиск')?> </button>
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
							<label for="filter_dept" class="form-label"><?php _l('Кафедра')?>: </label>
							<select class="form-select form-select-sm" id="filter_dept" name="filter_dept">
								<option value=""> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_dept, $filter_departments) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_subject" class="form-label"><?php _l('Предмет')?>: </label>
							<select class="form-select form-select-sm" id="filter_subject" name="filter_subject">
								<option value=""> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_subject, $filter_subjects) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_sem" class="form-label"><?php _l('Cеместр')?>: </label>
							<select class="form-select form-select-sm" id="filter_sem" name="filter_sem">
								<option value=""> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_sem, $filter_semesters) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_mdl" class="form-label"><?php _l('Модуль')?>: </label>
							<select class="form-select form-select-sm" id="filter_mdl" name="filter_mdl">
								<option value=""> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_mdl, $filter_modules) ?>
							</select>
						</div>
					</div>
				</div>
				<div class="row pt-2">
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_tutor" class="form-label"><?php _l('Преподаватель')?>: </label>
							<select class="form-select form-select-sm" id="filter_tutor" name="filter_tutor">
								<option value=""> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_tutor, $filter_tutors) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_daterange" class="form-label"><?php _l('Диапазон дат')?>:</label>
							<input type="text" class="form-control form-control-sm" id="filter_daterange" name="filter_daterange" value="<?php if (isset($_POST['filter_daterange'])) echo $_POST['filter_daterange']?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="status_filter">
							<label class="form-label"><?php _l('Статус модуля')?>:</label>
							<div>
								<div class="form-check form-check-inline">
									<label class="form-check-label">
										<input class="form-check-input" type="radio" id="filter_status" name="filter_status" value=""<?php if (empty($filter_status)) echo " checked"?>>Skip it
									</label>
								</div>
								<?php
								foreach ($modulesMeta['statuses'] as $bKey=>$bVal) {
									?>
									<div class="form-check form-check-inline">
										<label class="form-check-label">
											<input class="form-check-input" type="radio" id="filter_status<?php echo $bKey?>" name="filter_status" value="<?php echo $bKey?>"
												<?php if ($filter_status == $bKey) echo " checked"?>
											>
											<span class="text-<?php echo $bVal[1]?>"><?php echo $bVal[0]?></span>
										</label>
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<!-- <div class="col-sm-4">
						<button type="submit" class="btn btn-sm btn-main" name="filter_action" value="apply_filters">
							<?php _l('Применить')?>&nbsp;<?php echo mb_strtolower(_ll('Фильтры'))?>
						</button>
					</div> -->
					<div class="col-sm-6">
						<a href="/modules/" class="btn btn-sm btn-info"> <?php _l('Очистить')?></a>
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
			<th class="w-5">Date</th>
			<th class="w-15">Teacher</th>
			<th class="w-30">Subject(<small>Subj.Sem.Mdl</small>)</th>
			<th class="w-20">Groups</th>
			<th>Status/Result</th>
			<th class="text-right">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$q = 1;
		foreach ($modules as $r) {
			$tr_class = ($id == $r['module_id']) ? "table-success": "";
			$sbjsemmdl = $r['sbj'] . "." . $r['sem'] . "." . $r['mdl'];
			$status_info = $module_statuses[$r['module_status']];
			$res_total = ( $results[$r['module_id']]['res_total'] > 0 ) ? $results[$r['module_id']]['res_total']: 0;
			$module_groups = explode("/", preg_replace('/(^\/)|(\/$)/', '', $r['module_groups']));
			$str_groups = "";
			foreach ($module_groups as $g) {
				$str_groups .= "<span class=\"text-nowrap\">" . $groups[$g] . "</span>; ";
			}
			$str_groups = substr($str_groups, 0, -2);
			?>
			<tr class="rws <?php echo $tr_class?>">
				<td class="align-middle"><?php echo $r['sDate']?><br /><small><?php echo $r['sTime']?></small></td>
				<td class="align-middle"><?php echo end(explode(')', $tutors_name[$r['tutor_id']]))?></td>
				<td class="align-middle">
					<?php echo $filter_subjects[$r['sbj']]?> (<small><?php echo $sbjsemmdl?></small>)<br>
					<small><?php echo $r['module_desc']?>; <?php echo $r['module_duration']?> min.</small>
				</td>
				<td class="align-middle"><?php echo $str_groups?></td>
				<td class="align-middle">
					<div class="btn-group text-nowrap">
						<button type="button" class="btn btn-sm <?php echo $status_info[2]?> dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
							<?php echo $status_info[0]?>
						</button>
						<div class="dropdown-menu ctrlBtn" data-pid="<?php echo $r['module_id']?>">
							<?php
							foreach( $module_statuses as $e ) {
								?>
								<button class="dropdown-item <?php echo $e[1]?>" data-mod="<?php echo strtolower($e[0])?>" data-page="status"><?php echo $e[0]?></button>
								<?php
							}
							?>
						</div>
						<?php if( $res_total > 0 ) { ?>
							<a href="?module_res_id=<?php echo $r['module_id']?>" class="btn btn-secondary btn-sm" role="button">
								<?php echo $res_total?> <i class="mx-1 fas fa-lg fa-poll"></i>
							</a>
						<?php } else { ?>
							<span class="btn btn-secondary btn-sm" role="button">
								<?php echo $res_total?><i class="mx-1 fas fa-lg fa-poll"></i>
							</span>
						<?php } ?>
					</div>
				</td>
				<td class="align-middle text-center">
					<div class="ctrlBtn" data-pid="<?php echo $r['module_id']?>">
						<button class="btn btn-success btn-sm" type="button" data-mod="edit" data-page="one"><i class="fas fa-pencil-alt"></i></button>
						<?php if ($res_total == 0) { ?>
							<button class="btn btn-danger btn-sm" type="button" data-mod="delete" data-page="delete"><i class="far fa-trash-alt"></i></button>
						<?php } ?>
					</div>
				</td>
			</tr>
			<?php
			$q++;
		}
		?>
		</tbody>
	</tbody>

</table>