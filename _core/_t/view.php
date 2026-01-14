<div class="row g-0">
	<div class="col-lg-6 pe-lg-2 mb-3">
		<div class="card h-lg-100 overflow-hidden">
			<div class="card-header bg-body-tertiary">
				<span class="h"><?php _l("Кафедры")?></span>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive scrollbar">
					<table class="table fs-main">
						<tbody>
							<?php
							foreach ($tutor_dept as $r) {
								$dept_title = ($lang == "en") ? $r['dept_title']: $r['dept_ru'];
								?>
								<tr>
									<td><?php echo $dept_title?></td>
									<td><?php echo $r['dept_code']?></td>
									<td><?php echo $r['role_title']?></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer bg-body-tertiary p-0"></div>
		</div>
	</div>
	<div class="col-lg-6 ps-lg-2 mb-3">
		<div class="card h-lg-100 overflow-hidden">
			<div class="card-header bg-body-tertiary">
				<span class="h"><?php _l("Предметы")?></span>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive scrollbar fs-10">
					<table class="table">
						<tbody>
							<?php
							foreach ($subjects as $r) {
								$subj_title = ($lang == "en") ? $r['subject_title']: $r['subject_ru'];
								$request = $TS->request_encode('scode', $r['subject_code']);
								?>
								<tr>
									<td><?php echo $subj_title?></td>
									<td><a href="/subjects/?<?php echo $request?>"><?php echo $r['subject_code']?></a></td>
									<td><?php echo $chapter_data[$r['subject_code']]['cnt']?> <?php echo mb_strtolower(_ll("Главы"))?></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer bg-body-tertiary p-0">
				<a class="h6 text-main d-inline-block py-2 px-3 my-1" href="/subjects/"><?php _l("Показать все")?> <?php echo mb_strtolower(_ll("Предметы"))?></a>
			</div>
		</div>
	</div>
</div>

<div class="row g-0">
	<div class="col-lg-6 pe-lg-2 mb-3">
		<div class="card h-lg-100 overflow-hidden">
			<div class="card-header bg-body-tertiary">
				<span class="h"><?php _l("Журналы")?> <small>( <?php echo count($ibooks)?> )</small></span>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive scrollbar">
					<table class="table fs-main">
						<tbody>
							<?php
							for ($i=0; $i<5; $i++) {
								$r = $ibooks[$i];
								$what = ($r['ibook_type'] == "pr") ? "Практика": "Лекция";
								$subj_title = ($lang == "en") ? $r['subject_title']: $r['subject_ru'];
								$request = $TS->request_encode('ibcode', $r['ibook_id']);
								?>
								<tr>
									<td><?php _l($what)?></td>
									<td><?php echo $r['semester_title']?></td>
									<td><?php echo $r['grup_title']?></td>
									<td><?php echo $subj_title?></td>
									<td><a href="/ibook/?<?php echo $request?>"><i class="fa-solid fa-link"></i></a></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer bg-body-tertiary p-0">
				<a class="h6 text-main d-inline-block py-2 px-3 my-1" href="/ibooks/"><?php _l("Показать все")?> <?php echo mb_strtolower(_ll("Журналы"))?></a>
			</div>
		</div>
	</div>
	<div class="col-lg-6 ps-lg-2 mb-3">
		<div class="card h-lg-100 overflow-hidden">
			<div class="card-header bg-body-tertiary">
				<span class="h"><?php _l("Ведомости")?> <small>( <?php echo count($sheets)?> )</small></span>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive scrollbar">
					<table class="table fs-main">
						<tbody>
							<?php
							for ($i=0; $i<5; $i++) {
								$r = $sheets[$i];
								$what = ($r['exam_id'] > 0) ? "Экзамен": "Зачет";
								$subj_title = ($lang == "en") ? $r['subject_title']: $r['subject_ru'];
								$request = $TS->request_encode('shcode', $r['sheet_id']);
								?>
								<tr>
									<td><?php _l($what)?></td>
									<td><?php echo $r['semester_title']?></td>
									<td><?php echo $r['grup_title']?></td>
									<td><?php echo $subj_title?></td>
									<td><a href="/sheet/?<?php echo $request?>"><i class="fa-solid fa-link"></i></a></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer bg-body-tertiary p-0">
				<a class="h6 text-main d-inline-block py-2 px-3 my-1" href="/sheets/"><?php _l("Показать все")?> <?php echo mb_strtolower(_ll("Ведомости"))?></a>
			</div>
		</div>
	</div>
</div>

<div class="row g-0">
	<div class="col-lg-6 col-xxl-12 mb-3 pe-lg-2 mb-3">
		<div class="card h-lg-100 overflow-hidden">
			<div class="card-header bg-body-tertiary">
				<span class="h"><?php _l("Модули")?></span>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive scrollbar">
					<table class="table fs-main">
						<tbody>
							<?php
							foreach ($modules as $r) {
								$str_groups = module_groups($module_groups, $r['module_id']);
								$str_chapters = module_chapters($module_chapters, $r['module_id'], "string");
								$status_info = $module_statuses[$r['module_status']];
								$request = $TS->request_encode('mdcode', $r['module_id']);
								?>
								<tr>
									<td><?php echo $r['sDate']?></td>
									<td><?php echo $str_groups?></td>
									<td><?php echo $str_chapters?></td>
									<td><?php echo $status_info?></td>
									<td><a href="/module/?<?php echo $request?>"><i class="fa-solid fa-link"></i></a></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer bg-body-tertiary p-0">
				<a class="h6 text-main d-inline-block py-2 px-3 my-1" href="/modules/"><?php _l("Показать все")?> <?php echo mb_strtolower(_ll("Модули"))?></a>
			</div>
		</div>
	</div>
</div>
<div class="row g-0">
	<div class="col-lg-6 col-xxl-12 mb-3 pe-lg-2 mb-3">
		<div class="card h-lg-100 overflow-hidden">
			<div class="card-header bg-body-tertiary">
				<span class="h"><?php _l("Экзамены")?></span>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive scrollbar">
					<table class="table fs-main">
						<tbody>
							<?php
							foreach ($exams as $r) {
								$str_groups = exam_groups($exam_groups, $r['exam_id']);
								$str_chapters = exam_chapters($exam_chapters, $r['exam_id']);
								?>
								<tr>
									<td><?php echo $r['sDate']?></td>
									<td><?php echo $str_groups?></td>
									<td><?php echo $str_chapters?></td>
									<td><?php echo $r['exam_desc']?></td>
									<td><a href="/exams/<?php echo $r['ibook_id']?>/"><i class="fa-solid fa-link"></i></a></td>
								</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="card-footer bg-body-tertiary p-0">
				<a class="h6 text-main d-inline-block py-2 px-3 my-1" href="/exams/"><?php _l("Показать все")?> <?php echo mb_strtolower(_ll("Экзамены"))?></a>
			</div>
		</div>
	</div>
</div>

<div class="row g-0">
	<div class="col-lg-6 col-xxl-12 mb-3 pe-lg-2 mb-3">
		<div class="card h-lg-100 overflow-hidden">
			<div class="card-header bg-body-tertiary">
				<?php _l("Модули обучения")?>
			</div>
			<div class="card-body pt-0 fs-10">
				<div class="row">
					<div class="col-auto">
						<p class="mt-3 text-warning"><?php _l("У вас нет записей в разделе")?> "<?php _l("Модули обучения")?>"</p>
					</div>
				</div>
			</div>
			<div class="card-footer bg-body-tertiary p-0"></div>
		</div>
	</div>
</div>