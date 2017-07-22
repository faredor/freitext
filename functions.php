<?php

function wpbootstrap_scripts_with_jquery()
{
	// Register the script like this for a theme:
	wp_register_script( 'custom-script', get_template_directory_uri() . '/bootstrap/js/bootstrap.js', array( 'jquery' ) );
	// For either a plugin or a theme, you can then enqueue the script:
	wp_enqueue_script( 'custom-script' );
}
add_action( 'wp_enqueue_scripts', 'wpbootstrap_scripts_with_jquery' );

if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));

require_once('wp-bootstrap-navwalker.php');

register_nav_menus( array(
    'primary' => __( 'Primary Menu', 'freitext' ),
) );



class Einsatz_Widget extends WP_Widget{
function __construct() {
	parent::__construct(
		'einsatz_widget', // Base ID
		'Einsatz Widget', // Name
		array('description' => __( 'Zeigt die letzten Einsaetze an'))
	   );
}
function update($new_instance, $old_instance) {
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['numberOfListings'] = strip_tags($new_instance['numberOfListings']);
	$instance['category'] = strip_tags($new_instance['category']);
	return $instance;
}

	function form($instance) {
		if( $instance) {
			$title = esc_attr($instance['title']);
			$numberOfListings = esc_attr($instance['numberOfListings']);
			$category = esc_attr($instance['category']);
		} else {
			$title = '';
			$numberOfListings = '';
			$category = '';
		}
		?>
			<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'einsatz_widget'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Kategorien:', 'einsatz_widget'); ?></label>
			<select id="<?php echo $this->get_field_id('category'); ?>"  name="<?php echo $this->get_field_name('category'); ?>">
				<?php
				$categories = get_categories();
				 ?>
				 <?php foreach($categories as $cat){
					 $cat_name = $cat->name;
					 $catid = $cat->cat_ID;?>
 				<option <?php echo $catid == $category ? 'selected="selected"' : '';?> value="<?php echo $catid;?>"><?php echo $cat_name; ?></option>
			<?php }?>
			</select>
			</p>
			<p>
			<label for="<?php echo $this->get_field_id('numberOfListings'); ?>"><?php _e('Anzahl der Einträge:', 'einsatz_widget'); ?></label>
			<select id="<?php echo $this->get_field_id('numberOfListings'); ?>"  name="<?php echo $this->get_field_name('numberOfListings'); ?>">
				<?php for($x=1;$x<=10;$x++): ?>
				<option <?php echo $x == $numberOfListings ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
				<?php endfor;?>
			</select>
			</p>
		<?php
		}

	function widget($args, $instance) {
	extract( $args );
	$title = apply_filters('widget_title', $instance['title']);
	$numberOfListings = $instance['numberOfListings'];
	$category = $instance['category'];
	echo $before_widget;
	if ( $title ) {
		echo $before_title . $title . $after_title;
	}
	$this->getEinsatzListings($numberOfListings, $category);
	echo $after_widget;
	}

	function getEinsatzListings($numberOfListings, $category) { //html
	global $post;
	$count = 0;
	$safecount = 0;
	$n = 0;
	//while loop makes sure that there is the right amount of postings with thumbnails
	while ( ($count < $numberOfListings) AND ($safecount <= 30) ) {
		$args = array( 'numberposts' => $numberOfListings+$n, 'category' => $category, 'post_status' => 'publish' );
		$recent_posts = wp_get_recent_posts($args);
		foreach( $recent_posts as $recent) {
			if ( has_post_thumbnail($recent['ID']) ) {
				$count = $count + 1;
			}
			else {
				$n = $n + 1;
			}
		}
		$safecount = $safecount + 1;
	}

		echo '<ol class="list-unstyled">';
		foreach( $recent_posts as $recent)
		{
			//if ( $recent['post_status'] == 'publish' )
			//{
				if ( has_post_thumbnail($recent['ID']) )
				{

					echo '<li class="recent-post-thumbnail">';
						//echo '<div class="thumbnail-wrapper">';
							//echo get_the_post_thumbnail($recent['ID'], array( 'class' => 'img-responsive gap-bottom center-block' ) );
							$image_src = wp_get_attachment_image_src( get_post_thumbnail_id($recent['ID']),'full' );
							echo '<a href="';
								echo get_permalink($recent['ID']);
								echo '" title="';
								echo esc_attr($recent['post_title']);
								echo ' ansehen">';
								echo '<img src="' . $image_src[0]  . '" width="100%"  class="img-responsive gap-bottom center-block"/>';
							echo '</a>';

						//echo '</div>';
						echo '<div class="teaser-text center-block">';
							echo '<h4><a class="no-a-style" href="';
								echo get_permalink($recent['ID']);
								echo '" title="';
								echo esc_attr($recent['post_title']);
								echo ' ansehen">';
								echo $recent['post_title'];
							echo '</a></h4>';
							echo '<span>';
								echo get_the_date('d.m.Y', $recent['ID']);
							echo '</span>';
							echo '<span class="text-justify">';
								echo '<a class="no-a-style" href="';
									echo get_permalink($recent['ID']);
									echo '" title="';
									echo esc_attr($recent['post_title']);
									echo ' ansehen">';
									if (has_excerpt($recent['ID'])) {
										echo get_the_excerpt($recent['ID']);
									}
									else {
										echo wp_trim_words($recent['post_content'],25);
									}
								echo '</a>';
							echo '</span>';
						echo '</div>';
					echo '</li>';
					echo '<hr/>';
				}

				/*else
				{
					echo '<li class="recent-post-thumbnail"><a href="';
					echo get_permalink($recent['ID']);
					echo '" title="';
					echo esc_attr($recent['post_title']);
					echo ' ansehen">';
					echo $recent['post_title'];
					echo '</a>';
					echo '<span>';
					echo get_the_date('d.m.Y', $recent['ID']);
					echo '</span>';
					echo '</li>';
					echo '<hr>';
				}*/
			//}
		}
		echo '</ol>';

}


} //end class Realty_Widget
register_widget('Einsatz_Widget');


function wpb_widgets_init() {

	register_sidebar( array(
		'name'          => 'Ankuendigung',
		'id'            => 'ankuendigung',
		'before_widget' => '<div class="announce-banner">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="ankuendigung-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'wpb_widgets_init' );




?>
