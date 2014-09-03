<?php
/**
 * @package Shepherd
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( in_array( 'has-post-thumbnail', get_post_class() ) ) { ?>
		<header class="entry-header" style="background-image: url('<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>')">
	<?php } else { ?>
		<header class="entry-header">
	<?php } ?>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php
			$format = get_post_format( get_the_ID() );
			if ( false === $format ) {
				$format = 'standard';
			}
			echo '<span class="post-format">' . $format . '</span>';
			?>
			<?php shepherd_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Read More <span class="meta-nav">&rarr;</span>', 'shepherd' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'shepherd' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'shepherd' ) );
				if ( $categories_list && shepherd_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', 'shepherd' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'shepherd' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Tagged %1$s', 'shepherd' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'shepherd' ), __( '1 Comment', 'shepherd' ), __( '% Comments', 'shepherd' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'shepherd' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->