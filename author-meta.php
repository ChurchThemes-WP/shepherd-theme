<?php
/**
 * @package Shepherd
 */

global $authordata;

if( is_single() ): ?>

<div class="author-meta">

	<div class="author-image">
		<?php echo get_avatar( get_the_author_meta('user_email'), 254 ); ?>
	</div>

	<div class="author-text">

		<h6><?php _e('About the Author', 'shepherd' ); ?></h6>

		<h3 class="author-name">
			<a href="><?php the_author_meta('user_url'); ?>"><?php the_author_meta( 'display_name' ); ?></a>
		</h3>

		<p><?php the_author_meta('description'); ?></p>

		<a href="<?php echo get_author_posts_url(get_the_author_ID()); ?>"><?php _e('View Posts &rarr;', 'shepherd' ); ?></a>

	</div>

</div>

<?php endif; ?>