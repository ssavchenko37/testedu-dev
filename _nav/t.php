<li class="nav-item">
	<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
		<div class="col-auto navbar-vertical-label"><?php echo strtolower(_ll("Ведомости")) ?></div>
		<div class="col ps-0">
			<hr class="mb-0 navbar-vertical-divider" />
		</div>
	</div>
	<a class="nav-link dropdown-indicator" href="#sheets" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="sheets">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fa-solid fa-file-pen"></span></span><span class="nav-link-text"><?php _l("Ведомости") ?></span></div>
	</a>
	<ul class="nav collapse multi-collapse show" id="sheets">
		<li class="nav-item"><a class="nav-link" href="/sheets/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Экзаменационные") ?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/practice/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Практика") ?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/sys-sheets/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Системные") ?></span></div>
		</a></li>
	</ul>
</li>

<li class="nav-item">
	<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
		<div class="col-auto navbar-vertical-label"><?php echo strtolower(_ll("Студенты")) ?></div>
		<div class="col ps-0">
			<hr class="mb-0 navbar-vertical-divider" />
		</div>
	</div>
	<a class="nav-link" href="/ibooks/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-book-open"></i></span><span class="nav-link-text"><?php _l("Журналы");?></span></div>
	</a>
	<?php if (!empty($tsdata['usr']['tutor_dean'])) { ?>
		<a class="nav-link" href="/makeups/" role="button">
			<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-ban"></i></span><span class="nav-link-text"><?php _l("Отработки");?></span></div>
		</a>
	<?php } ?>
	
</li>

<li class="nav-item">
	<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
		<div class="col-auto navbar-vertical-label"><?php echo strtolower(_ll("Тестирование")) ?></div>
		<div class="col ps-0">
			<hr class="mb-0 navbar-vertical-divider" />
		</div>
	</div>
	<a class="nav-link" href="/modules/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-pencil"></i></span><span class="nav-link-text"><?php _l("Модули");?></span></div>
	</a>
	<a class="nav-link" href="/exams/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-pen-nib"></i></span><span class="nav-link-text"><?php _l("Экзамены");?></span></div>
	</a>
</li>

<li class="nav-item">
	<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
		<div class="col-auto navbar-vertical-label"><?php echo strtolower(_ll("Обучение")) ?></div>
		<div class="col ps-0">
			<hr class="mb-0 navbar-vertical-divider" />
		</div>
	</div>
	<a class="nav-link" href="/subjects/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-book"></i></span><span class="nav-link-text"><?php _l("Предметы");?></span></div>
	</a>
	<?php if ($tsdata['usr']['tutor_id'] == 307) { ?>
		<a class="nav-link" href="/chapters/">
			<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-receipt"></i></span><span class="nav-link-text"><?php _l("Главы")?></span></div>
		</a>
		<a class="nav-link" href="/questions/">
			<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-receipt"></i></span><span class="nav-link-text"><?php _l("Вопросы")?></span></div>
		</a>
		<a class="nav-link" href="/answers/">
			<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-receipt"></i></span><span class="nav-link-text"><?php _l("Ответы")?></span></div>
		</a>
	<?php }?>
	<a class="nav-link" href="/training/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-book-open-reader"></i></span><span class="nav-link-text"><?php _l("Модули обучения");?></span></div>
	</a>
</li>