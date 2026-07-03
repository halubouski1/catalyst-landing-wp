<?php
/**
 * Template Name: SEO Page
 *
 * SEO landing with the site header/footer. The body is written in the page
 * editor (the_content); title/description/keywords/robots come from per-page
 * ACF fields (see header.php / catalyst_meta_* in functions.php).
 *
 * @package Catalyst
 */

get_header();
?>

<main class="site-main">
	<section class="seo">
		<?php
		while ( have_posts() ) :
			the_post();
			the_content();
		endwhile;
		?>
	</section>
</main>

<?php
get_footer();
