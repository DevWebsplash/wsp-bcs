<?php
/**
 * Default page template
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */


?>
<?php
get_header();
if ( is_woocommerce() || is_cart() || is_checkout() || is_checkout_pay_page() ) {
?>
	<div class="block-woocommerce" >
    <header>
      <div class="cn cn--md">
        <h1 class="block__title"><?php the_title(); ?></h1>
      </div>
    </header>
    <?php the_content(); ?>
	</div>
<?php
} else if ( is_account_page() ) {
  ?>
  <header class="woo-account-head">
    <div class="cn cn--md">
      <h1 class="xl"><?php the_title(); ?></h1>
    </div>
  </header>
  <div class="block-woocommerce">
    <div class="cn cn--lg">
      <?php the_content(); ?>
    </div>
  </div>

  <?php
} else {
?>
	<article class="2" >
		<header>
			<h1><?php the_title(); ?></h1>
		</header>
		<?php the_content(); ?>
	</article>
<?php
}
get_footer( );
