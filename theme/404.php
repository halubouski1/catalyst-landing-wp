<?php
/**
 * 404 (page not found).
 *
 * @package Catalyst
 */

get_header();
?>

<main class="site-main">

<section class="hero">
	<img class="hero__video" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/404.png' ) ); ?>" alt="404">

	<div class="err-fours">
		<span class="err-four">4</span>
		<span class="err-four">4</span>
	</div>

	<div class="err__inner">

		<div></div>

		<div class="err-bottom">
			<div class="err-left">
				<span class="err-label"><?php echo esc_html( catalyst_t( 'error', 'ошибка' ) ); ?></span>
				<p class="err-desc"><?php echo esc_html( catalyst_t( 'Sorry, the page you were looking for does not exist, go back one step and try another option', 'Извините, запрашиваемая страница не существует. Вернитесь назад и попробуйте другой вариант' ) ); ?></p>
			</div>
			<a href="<?php echo esc_url( catalyst_lang_url( catalyst_lang() ) ); ?>" class="hero__cta err__btn">
				<?php echo esc_html( catalyst_t( 'Go for main', 'На главную' ) ); ?>
				<svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
					<circle cx="19.5" cy="19.5" r="19.5" fill="#FF5300"/>
					<path d="M23.0027 17.845L15.4716 25.0175L14.2344 23.8392L21.7646 16.6667H15.1278V15H24.7527V24.1667H23.0027V17.845Z" fill="white"/>
				</svg>
			</a>
		</div>

	</div>
</section>

</main>

<?php
get_footer();
