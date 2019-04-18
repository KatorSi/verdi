<nav class="side-navbar">
	<div class="side-navbar-wrapper">
		<div class="sidenav-header d-flex align-items-center justify-content-center">
			<div class="sidenav-header-inner text-center">
                <h2 class="h5"><?php echo Auth_client_api::$user['name']; ?></h2>
<!--				<span>%Role%</span>-->
			</div>
		</div>
		<div class="main-menu">
			<ul id="side-main-menu" class="side-menu list-unstyled">
				<li>
					<a href="<?= \Config::$host. 'dashboard/composer' ?>" >Композиторы</a>
				</li>
				<li>
					<a href="<?= \Config::$host . 'dashboard/opera' ?>">Оперы</a>
				</li>
				<li>
					<a href="<?= \Config::$host . 'dashboard/poster' ?>">Афиша</a>
				</li>
				<li>
					<a href="#libs" aria-expanded="false" data-toggle="collapse">Справочники</a>
					<ul id="libs" class="collapse list-unstyled ">
						<li>
							<a href="<?= \Config::$host . 'dashboard/country' ?>">Страны</a>
						</li>
						<li>
							<a href="<?= \Config::$host . 'dashboard/genre' ?>">Муз. направления</a>
						</li>
						<li>
							<a href="<?= \Config::$host . 'dashboard/librettist' ?>">Либреттисты</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
<div class="page">
	<header class="header">
		<nav class="navbar">
			<div class="container-fluid">
				<div class="navbar-holder d-flex align-items-center justify-content-between">
					<div class="navbar-header">
						<a id="toggle-btn" href="#" class="menu-btn"><i class="fa fa-bars fa-lg"></i></a>
						<a href="<?= \Config::$host . 'dashboard' ?>" class="navbar-brand">
							<div class="brand-text d-none d-md-inline-block">
								<strong class="text-primary">верди.рф</strong>
							</div>
						</a>
					</div>
					<ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
						<li class="nav-item">
							<a href="#" id="profileLogoutBtn" class="nav-link logout">
								<span class="d-none d-sm-inline-block">Logout</span>
								<i class="fa fa-sign-out"></i>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<section class="mt-30px mb-30px">
		<div class="container-fluid">
			<div class="row">