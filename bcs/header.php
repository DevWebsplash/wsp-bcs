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

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope="itemscope" itemtype="https://schema.org/WebPage">
<?php
//$header = 'header--white';
//if (
//    is_product()  ||
//    is_cart()     ||
//    is_checkout() ||
//    is_page_template( array(
//        'templates/how-it-works.php',
//        'templates/gallery-single.php'
//    )
//  )) {
//  $header = 'header--dark';
//} ?>

<div class="page-wrapper">
  <header class="header">
    <div class="cn">
      <div class="header__inner">
        <div class="toggle-menu"><span></span><span></span></div>
        <div class="header__logo">
          <a href="/staging/" title="Home page"><img src="<?php echo get_template_directory_uri();?>/assets/images/logo.png" loading="lazy" alt="Logo"></a>
        </div>
        <nav class="header__nav">
          <div class="cn">
            <ul class="main-menu">
              <li>
                <a href="#">Services</a>
                <span class="icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.70711 8.29289C6.31658 7.90237 5.68342 7.90237 5.29289 8.29289C4.90237 8.68342 4.90237 9.31658 5.29289 9.70711L11.2929 15.7071C11.6834 16.0976 12.3166 16.0976 12.7071 15.7071L18.7071 9.70711C19.0976 9.31658 19.0976 8.68342 18.7071 8.29289C18.3166 7.90237 17.6834 7.90237 17.2929 8.29289L12 13.5858L6.70711 8.29289Z"/>
                  </svg>
                </span>
                <ul>
                  <li><a href="#">Brake Caliper Refurbishment</a></li>
                  <li><a href="#">Repair Service</a></li>
                  <li><a href="#">Engineering</a></li>
                  <li><a href="#">High-End Brake Caliper Painting</a></li>
                  <li><a href="#">ReManufacture and Coatings</a></li>
                </ul>
              </li>
              <li>
                <a href="/staging/products/">Products</a>
                <span class="icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.70711 8.29289C6.31658 7.90237 5.68342 7.90237 5.29289 8.29289C4.90237 8.68342 4.90237 9.31658 5.29289 9.70711L11.2929 15.7071C11.6834 16.0976 12.3166 16.0976 12.7071 15.7071L18.7071 9.70711C19.0976 9.31658 19.0976 8.68342 18.7071 8.29289C18.3166 7.90237 17.6834 7.90237 17.2929 8.29289L12 13.5858L6.70711 8.29289Z"/>
                  </svg>
                </span>
                <ul>
                  <li><a href="#">Headline 1</a></li>
                  <li><a href="#">Headline 2</a></li>
                  <li><a href="#">Headline 3</a></li>
                </ul>
              </li>
              <li><a href="/staging/">Portfolio</a></li>
              <li><a href="/staging/vehicle/">Vehicles</a></li>
              <li>
                <a href="#">About us</a>
                <span class="icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.70711 8.29289C6.31658 7.90237 5.68342 7.90237 5.29289 8.29289C4.90237 8.68342 4.90237 9.31658 5.29289 9.70711L11.2929 15.7071C11.6834 16.0976 12.3166 16.0976 12.7071 15.7071L18.7071 9.70711C19.0976 9.31658 19.0976 8.68342 18.7071 8.29289C18.3166 7.90237 17.6834 7.90237 17.2929 8.29289L12 13.5858L6.70711 8.29289Z"/>
                  </svg>
                </span>
                <ul>
                  <li><a href="#">Headline 1</a></li>
                  <li><a href="#">Headline 2</a></li>
                  <li><a href="#">Headline 3</a></li>
                  <li><a href="#">Contact us</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <div class="header__action">
          <a href="#" class="btn btn-1">Get quote</a>
        </div>
      </div>
    </div>
  </header>

  <main class="content">
