<?php get_header(); ?>

<main class="container" style="padding: 200px 0 140px;">
  <header>
    <h1 style="font-family: var(--font-serif); font-size: 48px; margin-bottom: 40px;">
      <?php the_archive_title(); ?>
    </h1>
  </header>

  <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
      <article <?php post_class(); ?> style="margin-bottom: 40px;">
        <h2 style="margin-bottom: 10px;">
          <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;"><?php the_title(); ?></a>
        </h2>
        <div style="opacity: 0.8;"><?php the_excerpt(); ?></div>
      </article>
    <?php endwhile; ?>

    <?php the_posts_pagination(); ?>
  <?php else : ?>
    <p>No posts found.</p>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
