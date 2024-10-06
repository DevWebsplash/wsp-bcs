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
  <title><?php wp_title ('&ndash;', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
  <link rel="pingback" href="<?php bloginfo ('pingback_url'); ?>">

  <?php wp_head (); ?>
</head>

<body <?php body_class (); ?> itemscope="itemscope" itemtype="https://schema.org/WebPage">
<div class="page-wrapper">
  <?php if(!is_page_template(array('templates/get-quote.php'))) { ?>
  <header class="header">
    <div class="cn">
      <div class="header__inner">
        <div class="toggle-menu"><span></span><span></span></div>
        <div class="header__logo">
          <a href="/staging/" title="Home page">  <?php $image_repeater = get_field ('header_logo', 'option'); ?>
            <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                 alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>" loading="lazy"></a>
        </div>
        <nav class="header__nav">
          <div class="cn">
            <?php
            wp_nav_menu (array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => "main-menu",
            )); ?>
          </div>
        </nav>
        <div class="header__action">
          <?php
          $link = get_field ('header_button', 'option');
          if ($link) {
            $link_url = $link[ 'url' ];
            $link_title = $link[ 'title' ];
            $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self'; ?>
            <a class="btn btn-1" href="<?php echo esc_url ($link_url); ?>"
               target="<?php echo esc_attr ($link_target); ?>"><?php echo esc_html ($link_title); ?></a>
          <?php } ?>
        </div>
      </div>
    </div>
  </header>
  <?php } ?>
  <main class="content">
