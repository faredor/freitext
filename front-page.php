<?php get_header(); ?>
<div class="container-fluid">
	<div class="row">
		<?php get_sidebar('announce'); ?>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-8">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
			</div>
			<hr>
		
		<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
		<?php endif; ?>
		
		</div>
		
		<div class="col-xs-12 col-sm-4 col-md-4">
			<?php get_sidebar(); ?>
		</div>
		
	</div>
</div>
<?php get_footer(); ?>