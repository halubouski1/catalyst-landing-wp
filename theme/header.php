<?php
/**
 * Header: document head, site header bar and the overlay navigation menu.
 *
 * @package Catalyst
 */

?>
<!DOCTYPE html>
<html lang="<?php echo 'ru' === catalyst_lang() ? 'ru-RU' : 'en-US'; ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	$catalyst_meta_desc     = catalyst_meta_description();
	$catalyst_meta_keywords = catalyst_meta_keywords();
	$catalyst_meta_robots   = catalyst_meta_robots();
	?>
	<?php if ( '' !== $catalyst_meta_desc ) : ?>
	<meta name="description" content="<?php echo esc_attr( $catalyst_meta_desc ); ?>">
	<?php endif; ?>
	<?php if ( '' !== $catalyst_meta_keywords ) : ?>
	<meta name="keywords" content="<?php echo esc_attr( $catalyst_meta_keywords ); ?>">
	<?php endif; ?>
	<?php if ( '' !== $catalyst_meta_robots ) : ?>
	<meta name="robots" content="<?php echo esc_attr( $catalyst_meta_robots ); ?>">
	<?php endif; ?>
	<script>document.documentElement.style.setProperty("--fixed-vh", window.innerHeight + "px");</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="header">
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="header__logo">
		<img src="<?php echo esc_url( catalyst_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
	</a>
	<div class="header-right">
		<button class="header__contact-btn"><?php echo esc_html( catalyst_t( 'Contact Us', 'Связаться с нами' ) ); ?></button>
		<button class="header__burger">
			<svg width="21" height="9" viewBox="0 0 21 9" fill="none" xmlns="http://www.w3.org/2000/svg">
				<rect width="21" height="1" fill="white"/>
				<rect y="4" width="21" height="1" fill="white"/>
				<rect y="8" width="21" height="1" fill="white"/>
			</svg>
		</button>
	</div>
</header>

<!-- Nav Menu -->
<div class="nav-menu" id="nav-menu">
	<picture>
		<source media="(max-width: 570px)" srcset="<?php echo esc_url( get_theme_file_uri( 'assets/img/menu-bg-mobile.png' ) ); ?>">
		<img class="nav-menu__bg" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/menu-bg.png' ) ); ?>" alt="">
	</picture>
	<img class="nav-menu__brand" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/menu-brand.png' ) ); ?>" alt="">
	<div class="nav-menu__inner">

		<div class="nav-menu__top">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-menu__logo">
				<img src="<?php echo esc_url( catalyst_logo_url() ); ?>" alt="<?php bloginfo( 'name' ); ?>">
			</a>
			<button class="nav-menu__close" id="nav-menu-close" aria-label="<?php echo esc_attr( catalyst_t( 'Close menu', 'Закрыть меню' ) ); ?>">
				<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M1.51216 18C1.12479 18 0.73743 17.853 0.443122 17.5565C-0.147707 16.9657 -0.147707 16.0078 0.443122 15.417L15.417 0.443113C16.0082 -0.147704 16.966 -0.147704 17.5569 0.443113C18.1477 1.03393 18.1477 1.99179 17.5569 2.58298L2.58266 17.5565C2.2843 17.853 1.8973 18 1.51216 18Z" fill="white"/>
					<path d="M16.4857 18C16.0987 18 15.7114 17.853 15.4171 17.5565L0.443395 2.58317C-0.147798 1.99229 -0.147798 1.03432 0.443395 0.443438C1.03422 -0.147813 1.99209 -0.147813 2.58292 0.443438L17.5566 15.4186C18.1478 16.0095 18.1478 16.9674 17.5566 17.5583C17.2605 17.853 16.8731 18 16.4857 18Z" fill="white"/>
				</svg>
			</button>
		</div>

		<nav class="nav-menu__nav">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => catalyst_menu_location( 'primary' ),
					'container'      => false,
					'items_wrap'     => '%3$s',
					'walker'         => new Catalyst_Overlay_Walker(),
					'fallback_cb'    => 'catalyst_overlay_menu_fallback',
				)
			);
			?>
		</nav>

		<div class="nav-menu__bottom">
			<div class="nav-menu__lang">
				<a class="nav-menu__lang-btn<?php echo 'ru' === catalyst_lang() ? '' : ' nav-menu__lang-btn--active'; ?>" href="<?php echo esc_url( catalyst_lang_url( 'en' ) ); ?>">En</a>
				<span class="nav-menu__lang-sep"></span>
				<a class="nav-menu__lang-btn<?php echo 'ru' === catalyst_lang() ? ' nav-menu__lang-btn--active' : ''; ?>" href="<?php echo esc_url( catalyst_lang_url( 'ru' ) ); ?>">Ru</a>
			</div>
		</div>

	</div>
</div>
