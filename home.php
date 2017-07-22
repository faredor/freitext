<?php get_header(); ?>

<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-8">
    <h1>BLOG</h1>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <p><em><?php the_time('j. F Y'); ?></em></p>
    <hr>

    <?php endwhile; else: ?>
      <p><?php _e('Sorry, there are no posts.'); ?></p>
    <?php endif; ?>

  </div>
  <div class="col-xs-12 col-sm-6 col-md-4">

	<?php get_sidebar(); ?>

  </div>
</div>

<?php get_footer(); ?>