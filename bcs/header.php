<?php
/**
 * Header template
 *
 * @author   <Author>
 * @version  1.0.0
 * @package  <Package>
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php wp_title( '&ndash;', true, 'right' ); ?></title>
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">


  <link rel="stylesheet" href="https://use.typekit.net/cqe6xsw.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.css">
  <?php wp_head(); ?>
<!--  <link rel="stylesheet" href="--><?php //echo get_template_directory_uri();?><!--/assets/css/aliciajdiamonds.min.css">-->

</head>

<body <?php body_class(); ?>>
<?php
$header = 'header--white';
if (
    is_product()  ||
    is_cart()     ||
    is_checkout() ||
    is_page_template( array(
        'templates/how-it-works.php',
        'templates/gallery-single.php'
    )
  )) {
  $header = 'header--dark';
} ?>
<header class="header <?php echo $header; ?>">
  <div class="cn cn--lg">

  </div>
</header>

<div class="page-wrapper">
<!--  <main class="content"  data-scroll-section>-->