<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Shepherd
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-footer-inner">
			<div class="footer-widget-area">
				<div class="footer-widget">
					<?php dynamic_sidebar( 'footer-1' ); ?>
				</div>
				<div class="footer-widget">
					<?php dynamic_sidebar( 'footer-2' ); ?>
				</div>
				<div class="footer-widget">
					<?php dynamic_sidebar( 'footer-3' ); ?>
				</div>
			</div>
			<div class="site-info">
				<div class="copyright-info">
					<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'shepherd' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'shepherd' ), 'WordPress' ); ?></a>
					<span class="sep"> | </span>
					<?php printf( __( 'Theme: %1$s by %2$s.', 'shepherd' ), 'Shepherd Pro', '<a href="https://upthemes.com/" rel="designer">UpThemes</a>' ); ?>
				</div>
				<div class="social-menu">
					<?php wp_nav_menu( array( 'theme_location' => 'social' ) ); ?>
				</div>
			</div><!-- .site-info -->
		</div><!-- .site-footer-inner -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
