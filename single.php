<?php get_header(); ?>

<div class="container-fluid">
	<div class="row">
	  <!-- <div class="col-xs-12 col-sm-6 col-md-8"> -->

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<h1 class="blog-title"><?php the_title(); ?></h1>
			<p class="blog-title-meta"><em><?php the_time('j. F Y'); ?></em></p>
			<div class="blogpost-single">
			<?php the_content(); ?>
			</div>
			<hr>
			<?php comments_template(); ?>
			
		<?php endwhile; else: ?>
			<p><?php _e('Sorry, this page does not exist.'); ?></p>
		<?php endif; ?>

	  <!-- </div> -->
	<!--   <div class="col-xs-6 col-md-4">
		<?php //get_sidebar(); ?>	
	  </div> -->
	  
	</div>
</div>
<?php get_footer(); ?>