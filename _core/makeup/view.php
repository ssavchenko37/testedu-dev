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
				<a href="/makeups/" class="btn btn-sm btn-secondary" role="button"> <i class="fa fa-angle-left" aria-hidden="true"></i> <?php _l('Вернуться')?> </a>
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
					<td class="align-middle entered-td" title="col<?php echo $x?>">
						<div class="input-group input-group-sm">
							<div class="entered-alt"><?php echo $meta[$muin]['tdate']?></div>
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
						if ($item['item_val'] == 'abs') {
							$bg_abs = ($item['is_abs'] == 1) ? "bg-abs": "bg-reabs";
							?>
							<td class="align-middle text-center showed <?php echo $bg_abs?>" data-item_id="<?php echo $item['item_id']?>">
								<span data-send="<?php echo $cuin?>"><?php echo $item['item_val'] ?></span>
							</td>
							<?php
						} else {
							?>
							<td class="align-middle text-center">
								<span><?php echo $item['item_val'] ?></span>
							</td>
							<?php
						}
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
</form>