<form method="post" action="/chapters/" id="frm0" name="forMain">
	<div class="row align-items-center">
		<div class="col-md-8">
			<h1><?php _l("Главы")?> <small>(<?php echo count($chapters)?>)</small></h1>
		</div>
		<div class="col-md-4 text-end ctrlBtn">
			<button class="btn btn-sm btn-main" type="button" data-mod="add" data-page="one"><i class="fa fa-plus" aria-hidden="true"></i> <?php _l('Добавить главу')?></button>
			<button class="btn btn-sm btn-primary" type="button" data-mod="" data-page="upload"><i class="fa-solid fa-download"></i> <?php _l('Импорт глав')?></button>
		</div>
	</div>

	<div class="card border border-secondary-subtle">
		<div class="card-header py-2 bg-light border-bottom border-secondary-subtle">
			<div class="row">
				<div class="col-sm-5 d-flex">
					<label for="schstr" class="col-form-label col-form-label-sm pe-3"><?php _l('Поиск')?>: </label>
					<div class="input-group input-group-sm">
						<input type="text" class="form-control form-control-sm" id="schstr" name="schstr"
							   value="<?php if( !empty($schstr) ) echo $schstr;?>" placeholder="<?php _l('Поиск по главе или коду')?>"/>
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
							<label for="filter_dept" class="form-label form-label-sm"><?php _l('Кафедра')?>: </label>
							<select class="form-select form-select-sm" id="filter_dept" name="filter_dept">
								<option value=""> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_dept, $departments) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_subject" class="form-label form-label-sm"><?php _l('Предмет')?>: </label>
							<select class="form-select form-select-sm" id="filter_subject" name="filter_subject">
								<option value=""> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_subject, $subjects) ?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_semester" class="form-label form-label-sm"><?php _l('Cеместр')?>: </label>
							<select class="form-select form-select-sm" id="filter_semester" name="filter_semester">
								<option value=""> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_semester, $semesters) ?>
                            
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="status_filter">
							<label for="filter_module" class="form-label form-label-sm"><?php _l('Модуль')?>: </label>
							<select class="form-select form-select-sm" id="filter_module" name="filter_module">
								<option value=""> -- <?php _l('Просмотреть все')?> -- </option>
								<?php echo getOptionsK($filter_module, $modules) ?>
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
						<a href="/chapters/" class="btn btn-sm btn-info">
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
		<th class="w-10"><?php _l('Код главы')?><br><small>Sbj.Sem.Mdl.Thm</small></th>
		<th class="w-45"><?php _l('Глава')?></th>
		<th class="w-15"><?php _l('Вопросы')?></th>
		<th class="w-20"><?php _l('Преподаватели')?></th>
		<th class="w-10 text-right">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$q = 1;
    
	foreach ($chapters as $r) {
		$tr_class = ($id == $r['chapter_id']) ? "table-success": "";
		$request = $TS->request_encode('ccode', $r['chapter_code']);
		?>
		<tr class="rws <?php echo $tr_class?>">
			<td class="align-middle"><?php echo $r['chapter_code']?></td>
			<td class="align-middle"><?php echo $r['chapter_title']?> (<small><?php echo $r['chapter_id']?></small>)</td>
			<td class="align-middle">
				<a class="btn btn-sm btn-outline-secondary <?php if (empty($questionsV3[$r['chapter_code']]))  echo "disabled"?>" href="/questions/?<?php echo $request?>" role="button">
					<?php _l('Вопросы')?> <span class="badge text-bg-secondary"><?php echo (empty($questionsV3[$r['chapter_code']])) ? 0 : $questionsV3[$r['chapter_code']]?></span>
				</a>
			</td>
			<td class="align-middle">
				<div class="ctrlBtn" data-pid="<?php echo $r['chapter_id']?>">
					<button class="btn btn-outline-secondary btn-sm" type="button" data-mod="edit_owners" data-page="owners">
						<?php
						foreach (explode('/', $r['owners']) as $o) {
							if ($o > 0) echo "<small title=\"" . $tutors[$o] . "\">" . $o . "</small>&nbsp; ";
						}
						?>
					</button>
				</div>
			<td class="align-middle text-center">
				<div class="ctrlBtn" data-pid="<?php echo $r['chapter_id']?>">
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