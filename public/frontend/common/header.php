<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Rapid HTML</title>

	<link rel="icon" href="images/logo.png" type="image/x-icon" />
	<!-- ==== Bootstrap CSS ==== -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" integrity="sha512-GQGU0fMMi238uA+a/bdWJfpUGKUkBdgfFdgBm72SUQ6BeyWjoY/ton0tEjH+OSH9iP4Dfh+7HM0I9f5eR0L/4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- ==== Poppins Fonts ==== -->
	<link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<!-- ==== Font Awesome CSS ==== -->
	<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.4/css/all.css" />
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
	<link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css'>
	<link href="plugins/datepicker/bootstrap-datepicker.css" rel="stylesheet" type="text/css" />
	<!-- ==== Owl Carausel CSS ==== -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- ==== Custom CSS ==== -->
	<link rel="stylesheet" href="css/star-rating.min.css" />
	<link rel="stylesheet" href="css/custom.css" />
</head>
<body>
<?php 
        if($_SERVER['HTTP_HOST'] == 'localhost')
        {
			$url = 'http://localhost/html/rapid/';
        }
        else
        {
            $url = '/';
        }
        $headerClass = explode('/', $_SERVER['REQUEST_URI']);
        $headerClass = array_filter($headerClass);
        $headerClass = array_values($headerClass);
        $headerClass = end($headerClass);
    ?>

<section class="header-main-section ">
	<div class="header_menu_wraper">
		<div class="container">
			<div class="row">
				<div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="head_navigation d-md-block d-none">
						<div class="left_area ">
							<div class="logo">
								<a href="index.php">
									<img src="images/logo.png" alt="..." />
								</a>
							</div>
							<div class="menus">
								<ul>
									<li>
										<a href="index.php">Home</a>
									</li>
									<li>
										<a href="blog.php">Blogs</a>
									</li>
									<li>
										<a href="contact_us.php">Contact Us</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="right_area">
							<div class="login_side">
								<ul class="home-side">
									<li class="search_li">
										<a href="login.php" class="btn btn-primary-2">Login</a>
									</li>
									<li class="search_li">
										<a href="sign_up.php" class="btn btn-primary">Register</a>
									</li>
									<!-- <li class="user">
										<div class="dropdown user">
											<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
											<div class="user-img">
												<img src="images/Rectangle 192.png" alt="..." />
											</div>
											</button>
											<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
												<li><a class="dropdown-item" href="dashboard_home.php"><i class="fal fa-home-alt"></i>My Account</a></li>
												<li><a class="dropdown-item" href="dashboard_setting.php"><i class="fal fa-cog"></i>Settings</a></li>
												<li><a class="dropdown-item" href="index.php"><i class="fal fa-sign-out"></i>Logout</a></li>
											</ul>
										</div>
									</li> -->
								</ul>
							</div>
						</div>
					</div>
					<div class="responsive_menu  d-md-none d-block">
						<div class="menu_boxes">
							<div class="logo">
								<div class="img_logo">
									<a href="index.php">
										<img src="images/logo.png" alt="..." />
									</a>
								</div>
							</div>
							<div class="right">
								<div class="cart">
									<a href="javascript:;"><i class="fi fi-rr-shopping-cart"></i></a>
								</div>
								<div class="open_close">
									<a href="javascript:;" class="res_menubar">
										<i class="fas fa-bars"></i>
									</a>
								</div>
							</div>
						</div>
						<div class="open_menu">
							<div class="top_area">
								<div class="logo_box">
									<a href="index.php">
										<img src="images/logo.png" alt="..." />
									</a>
								</div>
								<div class="cross_menu">
									<a href="javascript:;">
										<i class="far fa-times"></i>
									</a>
								</div>
							</div>
							<div class="inner_res_menu inner_sidebar">
								<ul class="ul_first">
									<li>
										<a href="plan.php">Home</a>
									</li>
									<li>
										<a href="javascript:;">News</a>
									</li>
									<li class="search_li">
										<a href="login.php">Login</a>
									</li>
									<li class="search_li">
										<a href="reset_password.php">Register</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>