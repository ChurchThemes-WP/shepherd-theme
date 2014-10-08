<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Shepherd
 */

if ( ! function_exists( 'shepherd_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function shepherd_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'shepherd' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'shepherd' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'shepherd' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'shepherd_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function shepherd_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'shepherd' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'shepherd' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'shepherd' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'shepherd_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function shepherd_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	echo '<span class="posted-on">' . $posted_on . '</span>';

}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function shepherd_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'shepherd_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'shepherd_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so shepherd_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so shepherd_categorized_blog should return false.
		return false;
	}
}

/**
 * Returns the URL of the featured image if it exists, otherwise returns false
 *
 * @return bool/string
 */
function shepherd_get_featured_image_url() {
	$featured_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'featured' );

	$featured_image_url = $featured_image_url[0];

	if ( $featured_image_url == "" )
		return false;
	else
		return $featured_image_url;
}

function shepherd_single_title(){

	if ( shepherd_get_featured_image_url() ) { ?>
		<header class="entry-header entry-header-wrapper" style="background-image: url('<?php echo shepherd_get_featured_image_url(); ?>')">
	<?php } else { ?>
		<header class="entry-header">
	<?php } ?>
		<div class="entry-header-row">
			<div class="entry-header-column">
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

				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</div><!-- .entry-header-column -->
		</div><!-- .entry-header-row -->
	</header><!-- .entry-header -->
<?php
}

/**
 * Flush out the transients used in shepherd_categorized_blog.
 */
function shepherd_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'shepherd_categories' );
}
add_action( 'edit_category', 'shepherd_category_transient_flusher' );
add_action( 'save_post',     'shepherd_category_transient_flusher' );
