<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 */
?>


<?php if ( is_active_sidebar( 'shop-sidebar' ) ) : ?>
  <div id="secondary" class="widget-area">
    <?php dynamic_sidebar( 'shop-sidebar' ); ?>
  </div>
<?php else : ?>
<!--  <div id="secondary" class="widget-area">-->
<!--    <p>No widgets found in the sidebar!</p>-->
<!--  </div>-->
<?php endif; ?>
