<div class="row mt-4">
	<div class="col-md-8">
		<h3>
			<?php echo _lt([$subject['subject_ru'], $subject['subject_title']])?>
			<br><small><?php echo $module['module_desc']?></small>
		</h3>
		<div class="d-flex gap-3">
			<small class="text-muted"><?php echo _lt([$tutor['tutor_fullru'],$tutor['tutor_fullname']])?></small>
			<small class="text-muted"><?php echo $module['date_formated']?></small>
		</div>		
	</div>
	<div class="col-md-4 text-end">
		<a href="/modules/" class="btn btn-sm btn-secondary" role="button"> <i class="fa fa-angle-left" aria-hidden="true"></i> <?php _l('Вернуться')?> </a>
	</div>
</div>

<br>
<table class="table table-striped table-hover border-secondary-subtle">
	<thead>
		<tr class="fixed-row sticky-top" style="top: 64px; background: #FFFFFF;">
			<th class="w-10"><?php _l('Дата')?></th>
			<th class="w-20"><?php _l('Студент')?></th>
			<th class="w-10"><?php _l('Группа')?></th>
			<th class="text-center"><?php _l('Отвечено')?></th>
			<th class="text-center"><?php _l('Верно')?></th>
			<th class="text-center"><?php _l('Неверно')?></th>
			<th class="text-center"><?php _l('Пропущено')?></th>
			<th class="text-center"><?php _l('Процент')?></th>
			<th class="text-center"><?php _l('Оценка')?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($results as $r) {
			$res_in_correct = $r['res_answered'] - $r['res_correct'];
			$res_skipped = $r['res_total'] - $r['res_answered'];
			$assest = get_assest($r['res_percent'], []);
			?>
			<tr>
				<td class="align-middle"><?php echo $r['sDate']?><br /><small><?php echo $r['sTime']?></small></td>
				<td class="align-middle"><?php echo $r['stud_name']?><br /> <small><?php echo $r['record_book']?></small> </td>
				<td class="align-middle"><?php echo $r['grup_title']?></td>
				<td class="align-middle text-center"><?php echo $r['res_answered']?></td>
				<td class="align-middle text-center"><?php echo $r['res_correct']?></td>
				<td class="align-middle text-center"><?php echo $res_in_correct?></td>
				<td class="align-middle text-center"><?php echo $res_skipped?></td>
				<td class="align-middle text-center"><strong><?php echo ceil($r['res_percent'])?>%</strong></td>
				<td class="align-middle text-center"><?php echo _lt([$assest['ru'],$assest['en']])?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>