<?php
/**
 * @package Shepherd
 */
?>

<?php
	if ( shepherd_get_featured_image_url() )
		$extra_classes[] = "has-featured-image";
?>

<?php do_action( 'shepherd_entry_before' ); ?>

<article id="post-<?php the_ID(); ?>" class="<?php echo implode( " ", get_post_class($extra_classes) ); ?>">

	<?php do_action('shepherd_entry_header'); ?>

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'shepherd' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<div class="entry-footer-right">
			<?php edit_post_link( __( 'Edit', 'shepherd' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'shepherd' ) );
				if ( $categories_list && shepherd_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in: %1$s', 'shepherd' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'shepherd' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Filed under: %1$s', 'shepherd' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->

<?php do_action( 'shepherd_entry_after' ); ?>