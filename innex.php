<!DOCTYPE html>
<html lang="en">
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
	<link rel="stylesheet" href="/assets/css/main.css?v=<?php echo time()?>">
</head>
<body>
	<main class="main">
		<div class="container-fluid">
			<div class="row min-vh-100 bg-100">
				<div class="col-6 d-none d-lg-block position-relative shadow">
					<div class="bg-holder"></div>
				</div>
				<div class="col-sm-10 col-md-6 px-sm-0 align-self-center mx-auto py-5">
					<div class="row justify-content-center g-0">
						<div class="col-lg-9 col-xl-8 col-xxl-6">
							<div class="card">
								<div class="card-header bg-circle-shape bg-shape text-center p-2">
									<h4 class="z-1 position-relative link-light my-2"><?php _l("Международная Школа Медицины")?></h4>
								</div>
								<div class="card-body p-4">
									<div class="row flex-between-center">
										<div class="col-auto">
											<h3><?php _l("Авторизоваться")?></h3>
											<p><?php _l("Войдите, используя свой адрес электронной почты/ник и пароль.")?></p>
										</div>
									</div>
									<form method="post" action="">
										<input type="hidden" name="login_mode" value="login">
										<div class="mb-3">
											<label class="form-label" for="split-login-email"><?php _l("Псевдоним или электронная почта")?></label>
											<input class="form-control" id="split-login-email" name="your_email" type="text">
										</div>
										<div class="mb-3">
											<div class="d-flex justify-content-between">
												<label class="form-label" for="split-login-password"><?php _l("Пароль")?></label>
											</div>
											<input class="form-control" id="split-login-password" name="your_pass" type="password">
										</div>
										<div class="row justify-content-between">
											<div class="col-auto">
												<div class="form-check mb-0"><input class="form-check-input" type="checkbox" id="split-checkbox" name="remember_me"><label class="form-check-label mb-0" for="split-checkbox">Remember me</label></div>
											</div>
											<div class="col-auto"><a class="fs-10" href="/forgot-password/">Forgot Password?</a></div>
										</div>
										<div class="mb-3"><button class="btn btn-main d-block w-100 mt-3" type="submit" name="submit">Log in</button></div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script src="/assets/js/main.js?v=<?php echo time()?>"></script>
</body>
</html>