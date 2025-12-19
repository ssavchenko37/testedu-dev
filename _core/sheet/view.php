<form method="post" id="frm0" name="frmadd" enctype="multipart/form-data" onsubmit="return false">
	<input type="hidden" id="sheet_id" name="sheet_id" value="<?php echo $sheet_id?>">
	<input type="hidden" id="s_credits" name="s_credits" value="<?php echo $sheet['modules']?>">
	<input type="hidden" id="exam_id" name="exam_id" value="<?php echo $sheet['exam_id']?>">
	<div class="row mt-4">
		<div class="col-md-8">
			<h4><?php _l($doc_title)?></h4>
		</div>
		<div class="col-md-4 text-end">
			<div class="ctrlBtn">
				<a class="btn btn-sm btn-outline-info" href="/sheet/export_pdf.php/?<?php echo $tsreq?>" role="button" target="_blank"> <i class="fas fa-lg fa-file-pdf"></i> Export to PDF</a>
				<a href="/sheets/" class="btn btn-sm btn-secondary" role="button"> <i class="fa fa-angle-left" aria-hidden="true"></i> <?php _l('Назад')?> </a>
			</div>
		</div>
		<div class="col-md-8">
			<span><?php _l('Специальность')?>:</span> 560001 "<?php _l('Лечебное дело')?>"<br />
			<span><?php _l('Группа')?>:</span> <?php echo str_replace("DGP","ВОП",$titles['group'])?><br />
			<span><?php _l('Дисциплина')?>:</span> <?php echo $titles['subject']?>
			<div class="d-inline-flex align-items-center ms-3 mb-2">
				<span class="text-muted me-2"><?php _l('Модули')?>:</span>
				<div class="input-group" style="max-width: 160px">
					<input type="text" class="form-control form-control-sm" id="modules" name="modules" value="<?php echo $sheet['modules']?>"/>
					<button class="btn btn-sm btn-main" type="button" id="update-modules"><?php _l('Применить')?></button>
				</div>
			</div><br />
			<span><?php _l('Преподаватель')?>:</span> <?php echo $titles['tutor']?>;
			<div class="d-inline-flex align-items-center ms-3">
				<span class="text-muted me-2"><?php _l('Ассистент')?>:</span>
				<input type="text" class="form-control form-control-sm" id="assist" name="assist" value="<?php echo $sheet['assist']?>" autocomplete="off"/>
			</div>
		</div>
		<div class="col-md-4">
			<span>Курс:</span> <?php echo ceil($titles['semester']/2)?><br />
			<span>Семестр:</span> <?php echo $titles['semester']?><br /> <?php echo $academic_year . " " . mb_strtolower(_ll('Учебный год'))?> 
		</div>
	</div>
</form>
<br>
<table class="table table-sheet table-bordered table-striped table-hover border-secondary-subtle">
	<thead>
	<tr class="fixed-row sticky-top">
		<th rowspan="2" class="w-5 text-center align-middle">#</th>
		<th rowspan="2" class="w-25 text-center align-middle"><?php _l('Студент')?></th>
		<th rowspan="2" class="text-center align-middle" style="line-height: 1"><small><?php _l('Зачетная книжка')?></small></th>
		<th class="text-center align-middle"><?php _l('Модуль')?> 1</th>
		<th class="text-center align-middle"><?php _l('Модуль')?> 2</th>
		<th class="text-center align-middle"><?php _l('Модуль')?> 3</th>
		<th class="text-center align-middle"><?php _l('Модуль')?> 4</th>
		<th rowspan="2" class="w-10 text-center align-middle" style="line-height: 1">
			<small><?php echo _lt(["Суммарный балл<br>по итогам<br>текущего контроля","Total Points<br>from<br>Current Assessment"])?></small>
		</th>
		<?php if ($subject['has_exam'] > 0) { ?>
			<th rowspan="2" class="text-center align-middle"><?php _l('Допуск')?></th>
			<th rowspan="2" class="text-center align-middle"><?php _l('Экзамен')?></th>
		<?php } else { ?>
			<th rowspan="2" class="text-center align-middle"><?php _l('Зачет')?></th>
		<?php } ?>
		<th rowspan="2" class="text-center align-middle"><?php _l('Итоговый балл')?></th>
		<th rowspan="2" class="text-center align-middle"><?php _l('Оценка')?></th>
	</tr>
		<tr>
			<?php
			for ($i=1; $i < 5; $i++) {
				$this_uin = 'm' . $i . '_date';
				$dis = ($i > $sheet['modules']) ? "disabled": "";
				$entered = ($i > $sheet['modules']) ? "": "entered";
				if ($i > $sheet['modules']) {
					$sheet[$this_uin] = '';
				}
				?>
				<th class="text-center">
					<div class="input-group input-group-sm">
						<input  type="text" class="form-control form-control-sm <?php echo $entered?>" id="<?php echo $this_uin?>" name="<?php echo $this_uin?>" value="<?php echo $sheet[$this_uin]?>" <?php echo $dis?> autocomplete="off"/>
					</div>
				</th>
				<?php
			}
			?>
		</tr>
	</thead>
	<tbody>
	<?php
	$q = 1;
	foreach ($students as $s) {
		$tmp = $s;
		$tmp['hasexam'] = $hasexam;
		$tmp['modules'] = $sheet['modules'];
		$check = check_allowed($tmp);

		if ($check['calc'] && $check['allowed'] < 1) {
			$s['grade'] = "2 (неуд)";
			$s['score'] = $s['total'] = "—";
		}
		if ($check['avg_accept'] < 1) {
			$s['avg'] = "—";
		}
		if($hasexam) {
			if ($s['score'] < MIN_PERCENT && $s['score'] > 0) {
				$check['calc'] = true;
				$s['grade'] = "2 (неуд)";
				$s['total'] = "—";
			}
		}
		?>
		<tr data-send="<?php echo $s['item_id']?>">
			<td class="align-middle"><?php echo $q?></td>
			<td class="align-middle"><?php echo _ls($s['stud_name']);?></td>
			<td class="align-middle"><?php echo $s['record_book']?></td>
			<?php
			for ($i=1; $i < 5; $i++) {
				$m_uin = 'module' . $i;
				if ($i <= $sheet['modules']) {
					?>
					<td class="align-middle text-center <?php if($edited) echo "edited"?>">
						<span data-send="<?php echo $m_uin?>"><b><?php echo !$s[$m_uin] ? 0 : $s[$m_uin] ?></b></span>
					</td>
					<?php
				} else {
					?>
					<td>&nbsp;</td>
					<?php
				}
			}
			?>
			<td class="align-middle text-center">
				<span class="item-avg"><?php echo $s['avg']?></span>
			</td>
			<td class="align-middle text-nowrap">
				<button class="btn btn-sm btn-credit <?php echo $check['type']?>" type="button">
					<i class="far <?php echo $check['icon']?>"></i>
					<small><?php echo $check['text']?></small></button>
			</td>
			<?php if ($hasexam) { ?>
				<td class="align-middle text-center edited">
					<span data-send="score" class="item-score"><b><?php echo $s['score']?></b></span>
				</td>
			<?php } ?>
			<td class="align-middle text-center">
				<span class="item-total"><?php if ($check['calc']) echo $s['total']?></span>
			</td>
			<td class="align-middle text-center">
				<span class="item-grade" style="font-size: 80%;"><?php if ($check['calc']) echo $s['grade']?></span>
			</td>
		</tr>
		<?php
		$q++;
	}
	?>
	</tbody>
</table>

<div class="modal fade" id="modulesQty" tabindex="-1" aria-labelledby="modulesQtyLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<strong class="modal-title" id="modulesQtyLabel">
					<?php echo _lt(["Изменить количество модулей для предмета", "Edit the number of modules for the subject."])?>
				</strong>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="modal-warning">
					<div class="icon text-danger">
						<i class="fa-solid fa-triangle-exclamation"></i>
					</div>
					<div class="text"><?php echo _lt(["Количество модулей этого предмета будет изменено,<br>для всех групп потока","The number of modules for this course will be changed,<br>for all groups of this intake"])?></div>
					
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><?php _l('Закрыть')?></button>
				<button type="button" class="btn btn-sm btn-main" id="doUpdModules"><?php _l('Применить')?></button>
			</div>
		</div>
	</div>
</div>