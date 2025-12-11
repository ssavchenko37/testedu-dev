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
		<li class="nav-item"><a class="nav-link" href="/sheets-repeat/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Повторные") ?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/sheets-rexam/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Пересдача") ?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/practice/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Практика") ?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/sys-sheets/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Системные") ?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/sheet-ctrl/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Настройки") ?></span></div>
		</a></li>
	</ul>
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
		<div class="col-auto navbar-vertical-label"><?php echo strtolower(_ll("Преподавание")) ?></div>
		<div class="col ps-0">
			<hr class="mb-0 navbar-vertical-divider" />
		</div>
	</div>
	<a class="nav-link" href="/departments/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-chalkboard-user"></i></span><span class="nav-link-text"><?php _l("Кафедры");?></span></div>
	</a>
	<a class="nav-link" href="/tutors/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-person-chalkboard"></i></span><span class="nav-link-text"><?php _l("Преподаватели");?></span></div>
	</a>
	<a class="nav-link" href="/ibooks/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-book-open"></i></span><span class="nav-link-text"><?php _l("Журналы");?></span></div>
	</a>
	<a class="nav-link" href="/syllabuses/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-book-open-reader"></i></span><span class="nav-link-text"><?php _l("Программы обучения");?></span></div>
	</a>
</li>

<li class="nav-item">
	<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
		<div class="col-auto navbar-vertical-label"><?php echo strtolower(_ll("Студенты")) ?></div>
		<div class="col ps-0">
			<hr class="mb-0 navbar-vertical-divider" />
		</div>
	</div>
	<a class="nav-link" href="/groupments/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-people-group"></i></span><span class="nav-link-text"><?php _l("Группы");?></span></div>
	</a>
	<a class="nav-link" href="/payments/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-tags"></i></span><span class="nav-link-text"><?php _l("Платежи");?></span></div>
	</a>
</li>

<li class="nav-item">
	<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
		<div class="col-auto navbar-vertical-label"><?php echo strtolower(_ll("Обучение")) ?></div>
		<div class="col ps-0">
			<hr class="mb-0 navbar-vertical-divider" />
		</div>
	</div>
	<a class="nav-link dropdown-indicator" href="#training" role="button" data-bs-toggle="collapse" aria-expanded="true" aria-controls="training">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><span class="fa-solid fa-book"></span></span><span class="nav-link-text"><?php _l("Обучение")?></span></div>
	</a>
	<ul class="nav collapse multi-collapse show" id="training">
		<li class="nav-item"><a class="nav-link" href="/subjects/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Предметы")?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/chapters/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Главы")?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/questions/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Вопросы")?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/answers/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Ответы")?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/semesters/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Семестры")?></span></div>
		</a></li>
		<li class="nav-item"><a class="nav-link" href="/plans/">
			<div class="d-flex align-items-center"><span class="nav-link-text"><?php _l("Планы")?></span></div>
		</a></li>
	</ul>
</li>

<li class="nav-item">
	<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
		<div class="col-auto navbar-vertical-label"><?php echo strtolower(_ll("Расписание")) ?></div>
		<div class="col ps-0">
			<hr class="mb-0 navbar-vertical-divider" />
		</div>
	</div>

	<a class="nav-link" href="/schedule/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-calendar-days"></i></span><span class="nav-link-text"><?php _l("Расписание");?></span></div>
	</a>
	<a class="nav-link" href="/room/" role="button">
		<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-school"></i></span><span class="nav-link-text"><?php _l("Аудитории");?></span></div>
	</a>
</li>