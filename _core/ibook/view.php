<form method="post" id="frm0" name="frmadd" enctype="multipart/form-data" onsubmit="return false">
	<input type="hidden" id="ibook_id" name="ibook_id" value="<?php echo $ibook['ibook_id'] ?>">
	<input type="hidden" name="tutor_id" value="<?php echo $ibook['tutor_id'] ?>">
	<input type="hidden" name="grm_id" value="<?php echo $ibook['grm_id'] ?>">
	<input type="hidden" name="grup_id" value="<?php echo $ibook['grup_id'] ?>">
	<input type="hidden" name="subject_id" value="<?php echo $ibook['subject_id'] ?>">
	<div class="row mt-4">
		<div class="col-md-10">
			<h4>
				<?php _l('Журнал учета оценок и посещаемости')?><br>
				<small>
					<?php echo _lt([$ibook['title_ru'],$ibook['title_en'],$ibook['title_kg']])?> - <?php ($ibook['ibook_type'] == "pr") ? _l('Практика'): _l('Лекция');?>;&nbsp;&nbsp;
					<?php echo $year?> <?php _l('Уч. год')?>;&nbsp;&nbsp;
					<?php _l('Cеместр')?> <?php echo $ibook['semester_id']?>;&nbsp;&nbsp;
					<?php echo $ibook['grup_title']?>
				</small>
			</h4>
		</div>
		<div class="col-md-2 text-end">
			<div class="ctrlBtn">
				<a href="/ibooks/" class="btn btn-sm btn-secondary" role="button"> <i class="fa fa-angle-left" aria-hidden="true"></i> <?php _l('Назад')?> </a>
			</div>
		</div>
	</div>
	<div class="table-frozen">
		<table class="table table-hover table-bordered border-dark-subtle">
			<thead>
			<tr>
				<td class="align-middle text-center">№</td>
				<td class="align-middle">Студент</td>
				<?php
				for ($x = 1; $x < $MAXDays; $x++) {
					$dis = '';
					$muin = 'col' . $x;
					?>
					<td class="align-middle entered-td entered" title="col<?php echo $x?>" data-meta_id="<?php echo $meta[$muin]['meta_id']?>">
						<div class="input-group input-group-sm">
							<div class="entered-alt"><?php echo $meta[$muin]['tdate']?></div>
							<input type="text" class="form-control form-control-sm " id="<?php echo $muin?>" name="<?php echo $muin?>" value="<?php echo $meta[$muin]['meta_date']?>" <?php echo $dis?>/>
						</div>
					</td>
					<?php
				}
				?>
			</tr>
			</thead>
			<tbody>
			<?php
			$q = 1;
			foreach ($students as $r) {
				?>
				<tr data-send="<?php echo $r['stud_id']?>">
					<td class="align-middle text-center"><?php echo $q?></td>
					<td class="align-middle"><span><?php echo studentShort($r['stud_name']) ?></span></td>
					<?php
					for ($x = 1; $x < $MAXDays; $x++) {
						$cuin = "col" . $x;
						$item = (is_array($items[$cuin][$r['stud_id']])) ? $items[$cuin][$r['stud_id']]: array();
						if ($item['is_abs'] == 1 && $is_do_abs) {
							?>
							<td class="align-middle text-center bg-abs" data-item_id="<?php echo $item['item_id']?>">
								<?php echo $item['item_val'] ?>
							</td>
							<?php
						} else {
							?>
							<td class="align-middle text-center edited edited_val" data-item_id="<?php echo $item['item_id']?>">
								<span data-send="<?php echo $cuin?>"><b><?php echo $item['item_val'] ?></b></span>
							</td>
							<?php
						}
					}
					?>
				</tr>
				<?php
				$q++;
			}
			foreach (array("meta_topic"=>"Class topic", "meta_class"=>"Type of class", "meta_hours"=>"Number of hours") as $k=>$meta_name) {
				$lang_n = ($lang == 'ru')
				?>
				<tr class="meta-row">
					<td>&nbsp;</td>
					<td class="align-middle text-right"><?php echo $meta_name?></td>
					<?php
					for ($x = 1; $x < $MAXDays; $x++) {
						$muin = 'col' . $x;
						?>
						<td class="<?php if ($k != "meta_topic" ) echo "align-middle ";?>text-center edited edited_meta <?php echo $k?>" data-meta_id="<?php echo $meta[$muin]['meta_id']?>">
							<span data-send="<?php echo $muin?>" data-field="<?php echo $k?>"><b><?php echo !$meta[$muin][$k] ? "" : $meta[$muin][$k] ?></b></span>
						</td>
						<?php
					}
					?>
				</tr>
				<?php
				$q++;
			}
			?>
			</tbody>
		</table>
	</div>
	<?php
	if ($ibook['ibook_type'] == "pr") { ?>
		<div class="table-meta">
			<table class="table table-hover table-bordered border-dark-subtle">
				<thead>
				<tr class="meta-header">
					<td class="align-middle" rowspan="2">№</td>
					<td class="align-middle" rowspan="2">Студент</td>
					<td class="text-center" colspan="4">Unit №1</td>
					<td class="text-center" colspan="4">Unit №2</td>
					<td class="text-center" colspan="4">Unit №3</td>
					<td class="text-center" colspan="4">Unit №4</td>
					<td class="text-center align-middle" rowspan="2">Final score</td>
					<td class="text-right align-middle" rowspan="2">Credit mark</td>
				</tr>
				<tr class="meta-tr">
					<?php
					for ($x = 1; $x <= 4; $x++) {
						foreach ($unit_scores as $j=>$unit_name) { ?>
							<td class="text-center"><?php echo $unit_name?></td>
						<?php }
					}
					?>
				</tr>
				</thead>
				<tbody>
				<?php
				$q = 1;
				foreach ($students as $r) {
					$lang_n = ($lang == 'ru');
					?>
					<tr data-send="<?php echo $r['stud_id']?>">
						<td class="align-middle"><?php echo $q?></td>
						<td class="align-middle"><span><?php echo studentShort($r['stud_name'])?></span></td>
						<?php
						for ($x = 1; $x <= 4; $x++) {
							$unit = $units[$x][$r['stud_id']];
							foreach ($unit_scores as $j=>$unit_name) {
								if ($j == "total") { ?>
									<td class="total<?php echo $x?> align-middle text-center">
										<strong><?php echo $unit[$j]?></strong>
									</td>
								<?php } else { ?>
									<td class="align-middle text-center edited edited_unit" data-unit_id="<?php echo $unit['unit_id']?>" data-unit_num="<?php echo $x?>">
										<span data-send="<?php echo $j?>"><b><?php echo !$unit[$j] ? "" : $unit[$j] ?></b></span>
									</td>
								<?php }
							}
						}
						?>
						<td class="final_score align-middle text-center"></td>
						<td class="credit_mark"></td>
					</tr>
					<?php
					$q++;
				}
				?>
				</tbody>
			</table>
		</div>
	<?php }
	?>
</form>