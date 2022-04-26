<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php bloginfo('name'); ?></title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
	<link rel="shortcut icon" href="<?php echo BASE_URL; ?>/images/favicon.ico">
	<!-- css -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/slick.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
	<!-- js -->
	<script src="<?php echo BASE_URL; ?>/js/jquery.min.js"></script>
	<script src="<?php echo BASE_URL; ?>/js/custom.js"></script>
	<?php wp_head(); ?>
</head>


<body <?php body_class() ?>>

	<div class="bg_opacity"></div>


		<div id="menu_mobile_full">
			<nav class="mobile-menu">
				<p class="close_menu"><span><i class="fa fa-times" aria-hidden="true"></i></span></p>
				<?php 
				$args = array('theme_location' => 'menu_mobile');
				?>
				<?php wp_nav_menu($args);?>
			</nav>
		</div>
	

	<header class="header">
		<div class="top_header">
			<!-- display account top_header mobile -->
			<?php if (is_user_logged_in() && wp_is_mobile() ): ?>
			<div class="after_login after_login_mb">
				<a href="<?php echo get_site_url();?>/tai-khoan">	
					<?php  $current_user = wp_get_current_user();
					echo '' . $current_user->user_login . '';
					?></a>
					| <a href="<?php echo wp_logout_url(); ?>" > Đăng xuất</a>
				</div>
			<?php endif; ?>
			<span class="icon_mobile_click"><i class="fa fa-bars" aria-hidden="true"></i></span>
			<div class="container">
				<div class="logo_site">
					<?php 
					if(has_custom_logo()){
						the_custom_logo();
					}
					else { ?> 
						<h2><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h2>
					<?php } ?>
				</div>
				
				<div class="search_address">
					<?php if(get_option('address_header') || get_option('phone')) { ?>
						<div class="address_header">
							<?php if(get_option('phone')){ ?>
							<p><i class="fa fa-phone" aria-hidden="true"></i><strong>Hotline : </strong><a href="tel:<?php echo get_option('phone'); ?>"> <?php echo get_option('phone'); ?></a></p>
							<?php }?>
							<?php if(get_option('address_header')){ ?>
							<p><i class="fa fa-map-marker" aria-hidden="true"></i><strong>Địa chỉ : </strong><?php echo get_option('address_header'); ?></p>
							<?php }?>
						</div>
					<?php }?>
					<div class="search_header">
						<?php //get_search_form(); ?>
						<form role="search" method="get" id="searchform" action="<?php echo home_url('/');  ?>">
							<div class="search">
								<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" placeholder="Tìm kiếm">
								<input type="hidden" value="product" name="post_type">
								<button type="submit" id="searchsubmit"><i class="fa fa-search"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="middle_header sticky">
			<div class="container">
				<span class="icon_mobile_click"><i class="fa fa-bars" aria-hidden="true"></i></span>
				<nav class="nav nav_primary">
					<?php 
					$args = array('theme_location' => 'primary');
					?>
					<?php wp_nav_menu($args); ?>
				</nav>
				<div class="cart_login">
					<?php if (is_user_logged_in()): ?>
						<div class="after_login">
							<a href="<?php echo get_site_url();?>/tai-khoan">	
								<?php  $current_user = wp_get_current_user();
								echo '' . $current_user->user_login . ' ';
								?></a>
								|  <a href="<?php echo wp_logout_url(); ?>" > Đăng xuất</a>
							</div>
						<?php endif; ?>
						<div class="tg_user <?php if (is_user_logged_in()): echo 'user_logged_in'; ?> <?php endif; ?> ">
							<a href="<?php echo get_site_url().'/tai-khoan';?>"><i class="fa fa-user" aria-hidden="true"></i></a>
							<div class="tg-sub-menu">
								<p><a href="<?php echo get_site_url().'/tai-khoan';?>">Đăng nhập</a> | <a href="<?php echo get_site_url().'/tai-khoan';?>">Đăng kí</a></p>
							</div>
						</div>
						<div class="g_cart">

							<?php global $woocommerce; ?>
							<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('Xem giỏ hàng', 'woothemes'); ?>">
								<?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> <?php //echo $woocommerce->cart->get_cart_total(); ?> 

							</a>
							<div class="header-quickcart">
								<?php woocommerce_mini_cart(); ?>
							</div>

						</div>
					</div>
				</div>
			</div>
			<?php if(is_front_page() && !is_home()){ ?>
		
			<?php } ?>
		</header>



