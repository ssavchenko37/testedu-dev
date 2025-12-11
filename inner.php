<!DOCTYPE html>
<html lang="ru">
	<head>
		<title><?php _l("МШМ")?> <?php _l("МУК")?></title>
		<meta charset="utf-8">
		<meta name="keywords" content="">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="format-detection" content="telephone=no">
		<link rel="shortcut icon" href="/assets/fav/favicon.ico" type="image/x-icon">
		<link rel="apple-touch-icon" href="/assets/fav/apple-touch-icon.png">
		<link rel="icon" type="image/png" sizes="192x192" href="/assets/fav/android-chrome-192x192.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/assets/fav/android-chrome-256x256.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/assets/fav/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/assets/fav/favicon-16x16.png">
		<link rel="manifest" href="/assets/fav/site.webmanifest">
		<link rel="mask-icon" href="/assets/fav/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/assets/fav/mstile-150x150.png">
		<meta name="msapplication-config" content="/assets/fav/browserconfig.xml">
		<meta name="theme-color" content="#ffffff">

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

		<link rel="stylesheet" href="/assets/css/all.min.css">
		<link rel="stylesheet" href="/assets/css/theme.min.css?v=<?php echo time()?>">
		<link href="/assets/css/flatpickr.min.css" rel="stylesheet">
		<link rel="stylesheet" href="/assets/css/main.css?v=<?php echo time()?>">
	</head>
	<body>
		<main>
			<div class="container-fluid <?php if ($sCore != "ibook") echo "container-xxl"?>" data-layout="container">
				<nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
					<div class="d-flex align-items-center">
						<div class="toggle-icon-wrapper">
							<button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle" data-bs-toggle="tooltip" data-bs-placement="left" aria-label="Toggle Navigation" data-bs-original-title="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
						</div>
						<a class="navbar-brand" href="index.html">
							<div class="d-flex align-items-center py-3">
								<img class="me-2" src="/assets/img/testedu-logo.png" alt="" width="40">
								<span class="font-sans-serif text-main">.EDU</span>
							</div>
						</a>
					</div>
					<div class="collapse navbar-collapse" id="navbarVerticalCollapse">
						<div class="navbar-vertical-content scrollbar">
							<ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
								<li class="nav-item d-flex">
									<a class="nav-link" href="/" role="button">
										<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-house"></i></span><span class="nav-link-text ps-1"><?php _l("Главная");?></span></div>
									</a>
									<a class="nav-all-collapse" role="button" data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="false" aria-controls="multiCollapseExample1 multiCollapseExample2"></a>
								</li>
								<?php
								if (is_file("_nav/" . $tsdata['umod'] . ".php")) {
									include "_nav/" . $tsdata['umod'] . ".php";
								} else {
									include "_nav/default.php";
								}
								?>
								<li class="nav-item">
									<div class="row navbar-vertical-label-wrapper mt-3 mb-2">
										<div class="col ps-0">
											<hr class="mb-0 navbar-vertical-divider" />
										</div>
									</div>
									<a class="nav-link" href="/logout/" role="button">
										<div class="d-flex align-items-center"><span class="nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></span><span class="nav-link-text ps-1"><?php _l("Выйти");?></span></div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
				<div class="content">
					<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand flex-wrap">
						<button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
						<a class="navbar-brand me-1 me-sm-3" href="index.html">
							<div class="d-flex align-items-center"><img class="me-2" src="/assets/img/testedu-logo.png" alt="" width="40"><span class="font-sans-serif text-main">.EDU</span></div>
						</a>
						<form class="m-0 ms-auto" action="" method="post">
							<div class="row ms-0">
								<label for="sheet_period" class="g-0 col-3 text-end col-form-label col-form-label-sm"><?php _l("Период")?>: </label>
								<div class="col-9">
									<select class="form-select form-select-sm" id="sheet_period" name="sheet_period">
										<?php echo getOptions($sheet_period, $period['list']) ?>
									</select>
								</div>
							</div>
						</form>
						<ul class="navbar-nav navbar-nav-icons flex-row align-items-center">
							<li class="nav-item ps-2 pe-0">
								<div class="dropdown theme-control-dropdown">
									<a class="nav-link d-flex align-items-center dropdown-toggle fs-9 pe-1 py-0" href="#" role="button" id="langSwitchDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<?php
										echo strtoupper($lang);
										?>
									</a>
									<div class="dropdown-menu dropdown-menu-end dropdown-caret border py-0 mt-3" aria-labelledby="langSwitchDropdown">
										<div class="bg-white dark__bg-1000 rounded-2 py-2">
											<a href="/?en" class="dropdown-item d-flex align-items-center gap-2 <?php if ($lang == "en") echo 'active';?>">
												<img class="lang-ico" src="/assets/img/en.svg" alt="En">
												English
												<svg class="svg-inline--fa fa-check fa-w-16 dropdown-check-icon ms-auto text-600" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
											</a>
											<a href="/?ru" class="dropdown-item d-flex align-items-center gap-2 <?php if ($lang == "ru") echo 'active';?>">
												<img class="lang-ico" src="/assets/img/ru.svg" alt="Ру">
												Русский
												<svg class="svg-inline--fa fa-check fa-w-16 dropdown-check-icon ms-auto text-600" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
											</a>
											<a href="/?kg" class="dropdown-item d-flex align-items-center gap-2 <?php if ($lang == "kg") echo 'active';?>">
												<img class="lang-ico" src="/assets/img/kg.svg" alt="Кг">
												Кыргызча
												<svg class="svg-inline--fa fa-check fa-w-16 dropdown-check-icon ms-auto text-600" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg>
											</a>
										</div>
									</div>
								</div>
							</li>
							<li class="nav-item ps-2 pe-0 dropdown">
								<a class="nav-link d-flex align-items-center dropdown-toggle pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<div class="avatar avatar-xl">
										<img class="rounded-circle" src="<?php echo $usrAvaImg?>" alt="<?php echo $usrAvaAlt?>">
									</div>
								</a>
								
								<div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
									<div class="bg-white dark__bg-1000 rounded-2 py-2">
										<strong class="dropdown-item"><?php echo $userName?></strong>
										<div class="dropdown-divider"></div>
										<?php if ( $tsdata['umod'] == "tch") { ?>
											<a class="dropdown-item" href="/t/profile"><?php _l("Профиль")?></a>
											<a class="dropdown-item" href="/t/avatar"><?php _l("Изменить фото")?></a>
											<a class="dropdown-item" href="/t/password/"><?php _l("Изменить пароль")?></a>
											<div class="dropdown-divider"></div>
										<?php } ?>
										<?php if ( $tsdata['umod'] == "std") { ?>
											<a class="dropdown-item" href="/s/profile"><?php _l("Профиль")?></a>
											<a class="dropdown-item" href="/s/avatar"><?php _l("Изменить фото")?></a>
											<a class="dropdown-item" href="/s/password/"><?php _l("Изменить пароль")?></a>
											<div class="dropdown-divider"></div>
										<?php } ?>
										<a class="dropdown-item" href="/t/settings/"><?php _l("Настройки")?></a>
										<a class="dropdown-item" href="/logout/"><?php _l("Выйти")?></a>
									</div>
								</div>
							</li>
						</ul>
					</nav>
                    <div id="workspace" class="ws">
						<?php
						if (is_file(S_ROOT . "/_core/" . $sMod . "/" . $sCore . "/view.php")) {
							include S_ROOT . "/_core/" .$sMod . "/" . $sCore . "/view.php";
						}
						if (is_file(S_ROOT . "/_core/" . $sCore . "/view.php") && $globalview) {
							include S_ROOT . "/_core/" . $sCore . "/view.php";
						}
						?>
						<?php include 'aside.php'; ?>
                    </div>
				</div>
			</div>
		</main>

		<script>const pathlast = '<?php echo $last?>'</script>
		<script src="/assets/js/popper.min.js"></script>
		<script src="/assets/js/bootstrap.bundle.js"></script>
		<script src="/assets/js/anchor.min.js"></script>
		<script src="/assets/js/is.min.js"></script>
		<script src="/assets/js/echarts.min.js"></script>
		<script src="/assets/js/all.min.js"></script>
		<script src="/assets/js/lodash.min.js"></script>
		<script src="/assets/js/list.min.js"></script>
		<script src="/assets/js/flatpickr.js"></script>
		<script src="/assets/js/flatpickr_ru.js"></script>
		<script src="/assets/js/main.js?v=<?php echo time()?>"></script>
        <?php if (is_file(S_ROOT . "/_core/" . $sCore . "/script.js")) { ?>
            <script src="<?php echo "/_core/" . $sCore . "/script.js?v=" . time()?>"></script>
        <?php } ?>
	</body>
</html>