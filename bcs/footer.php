<?php
/**
 * Footer template
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */
?>
</main>

<?php if(!is_page_template(array('templates/get-quote.php'))) { ?>
<footer class="footer">
    <div class="cn">
        <div class="footer__main">
            <div class="footer__info">
                <div class="title"><?php echo get_field('footer_info_title', 'option');?></div>
	            <?php echo get_field('footer_info', 'option');?>
            </div>
            <nav class="footer__nav">
	            <?php
	            wp_nav_menu( array(
		            'theme_location' => 'wfooter_first',
		            'container'			=> false,
	            ) ); ?>
		            <?php
		            wp_nav_menu( array(
			            'theme_location' => 'footer_second',
			            'container'			=> false,
		            ) ); ?>
            </nav>
            <div class="footer__actions">
	            <?php  if ( have_rows( 'footer_actions', 'option' ) ): ?>
		            <?php while ( have_rows( 'footer_actions', 'option' ) ) : the_row(); ?>
				            <?php $image_repeater = get_sub_field( 'icon' ); ?>
                        <a href="<?php echo get_sub_field( 'link' ); ?>" class="item">
                            <span class="icon"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                                    loading="lazy"
                                                    alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></span>
                            <span><?php echo get_sub_field( 'title' ); ?></span>
                            <span class="arrow"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/chevron-right.svg" loading="lazy" alt=""></span>
                        </a>
		            <?php endwhile;?>
	            <?php endif; ?>
            </div>
        </div>

        <div class="footer__bottom">
            <div class="links">
	            <?php  if ( have_rows( 'footer_bottom_links', 'option' ) ): ?>
		            <?php while ( have_rows( 'footer_bottom_links', 'option' ) ) : the_row(); ?>
                         <?php
				            $link = get_sub_field( 'link' );
				            if ( $link ):
					            $link_url    = $link['url'];
					            $link_title  = $link['title'];
					            $link_target = $link['target'] ? $link['target'] : '_self';
					            ?>
                                <a href="<?php echo esc_url( $link_url ); ?>"  <?php echo esc_attr( $link_target ); ?>><?php echo esc_html( $link_title ); ?></a>
							<?php endif; ?>
		            <?php endwhile;?>
	            <?php endif; ?>
            </div>
            <div class="copyright"> <?php echo get_field('copyright', 'option');?></div>
        </div>
    </div>
</footer>
<?php } ?>
</div>


<?php wp_footer(); ?>

</body>
</html>
