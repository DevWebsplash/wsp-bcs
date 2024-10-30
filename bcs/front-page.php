<?php get_header ();
/* Template Name: Home */
?>

<!--  <section class="b-hero align-center text-center">-->
<!--    <div class="cn cn--lg">-->
<!--      <h1 class="b-hero__title">--><?php //the_field( 'header_title1' ); ?><!--</h1>-->
<!--      <p>--><?php //the_field( 'header_subtitle1' ); ?><!--</p>-->
<!--      <a class="btn btn-white" href="--><?php //the_field( 'header_button_link1' ); ?><!--">--><?php //the_field( 'header_button_title1' ); ?><!--</a>-->
<!--    </div>-->
<!--  </section>-->

<!--VEHICLES-->
<section class="s-vehicles-simple ms-section">
  <div class="section-bg">
    <img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-08.jpg" alt="hero screen"></div>
  <div class="cn">
    <div class="section-heading">
      <h1 class="title h1"><?php echo get_field ('home_hero_title'); ?></h1>
      <div class="subtitle"><?php echo get_field ('home_hero_subtitle'); ?></div>
    </div>
    <?php echo render_vehicle_search_form (); ?>
  </div>
</section>
<?php
// Check value exists.
if (have_rows ('home_content')):
  $i = 0;
  // Loop through rows.
  while (have_rows ('home_content')) : the_row ();
    $i++;
    // Case: Paragraph layout.
    if (get_row_layout () == 'text_with_image'):?>
      <!--WHY-->
      <section class="s-why ms-section">
        <div class="cn">
          <div class="s-why__inner">
            <?php $image_repeater = get_sub_field ('text_with_image'); ?>
            <div class="s-why__img">
              <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                   alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
            </div>
            <div class="s-why__content">
              <div class="section-heading">
                <h2 class="title h1"><?php echo get_sub_field ('text_with_image_title'); ?></h2>
                <div class="subtitle h2"><?php echo get_sub_field ('text_with_image_subtitle'); ?></div>
              </div>
              <div class="desc"><?php echo get_sub_field ('text_with_image_text'); ?></div>
              <?php
              $link = get_sub_field ('text_with_image_button');
              if ($link):
                $link_url = $link[ 'url' ];
                $link_title = $link[ 'title' ];
                $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
                ?>
                <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-8"
                   target="<?php echo esc_attr ($link_target); ?>">
                  <?php echo esc_html ($link_title); ?>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'services'): ?>
      <!--SERVICES-->
      <section class="s-services-main ms-section">
        <div class="s-services-main__head">
          <div class="section-bg">
            <img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-02.png" loading="lazy" alt=""></div>
          <div class="cn">
            <div class="section-heading">
              <h2 class="title h1"><?php echo get_sub_field ('services_title'); ?></h2>
              <div class="subtitle"><?php echo get_sub_field ('services_subtitle'); ?></div>
              <div class="decorated-title decorated-title--row-left">
                <div class="small-title small-title--white"><?php echo get_sub_field ('services_title'); ?></div>
                <div class="line-decor line-decor--white"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="cn">
          <div class="services-list">
            <?php
            $featured_posts = get_sub_field ('services');
            if ($featured_posts): ?>
              <?php foreach ($featured_posts as $post):

                // Setup this post for WP functions (variable must be named $post).
                setup_postdata ($post); ?>
                <div class="service-item">
                  <?php $image_repeater = get_field ('services_preview_image'); ?>
                  <div class="img">
                    <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                         alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                  </div>
                  <h3 class="title"><?php the_title (); ?></h3>
                  <div class="desc"><?php the_field ('services_preview_description'); ?></div>
                  <a href="<?php the_permalink (); ?>" class="btn btn-2">
                    <span>Read more</span>
                    <span class="icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                        <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                      </svg>
                    </span>
                  </a>
                </div>
              <?php endforeach; ?>

              <?php
              // Reset the global post object so that the rest of the page works correctly.
              wp_reset_postdata (); ?>
            <?php endif; ?>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'icon_with_text'): ?>
      <!--THREE COLUMN variant 2-->
      <section class="s-three-column s-three-column--variant-2 ms-section">
        <div class="cn">
          <div class="section-heading">
            <div class="decorated-title decorated-title--column-center">
              <div class="small-title small-title--gray"><?php echo get_sub_field ('icon_with_text_title'); ?></div>
              <div class="line-decor line-decor--red"></div>
            </div>
            <h2 class="title h1"><?php echo get_sub_field ('icon_with_text_title'); ?></h2>
            <div class="subtitle"><?php echo get_sub_field ('icon_with_text_subtitle'); ?></div>
          </div>

          <div class="s-three-column__list">
            <?php if (have_rows ('icon_with_text')): ?>
              <?php while (have_rows ('icon_with_text')) : the_row (); ?>
                <div class="item">
                  <?php $image_repeater = get_sub_field ('icon'); ?>
                  <div class="img">
                    <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                         loading="lazy" alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                  </div>
                  <h3 class="title"><?php echo get_sub_field ('name'); ?></h3>
                  <div class="desc"><?php echo get_sub_field ('text'); ?></div>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>


          </div>
          <?php
          $link = get_sub_field ('text_with_image_button');
          if ($link):
            $link_url = $link[ 'url' ];
            $link_title = $link[ 'title' ];
            $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
            ?>
            <div class="section-btn" target="<?php echo esc_attr ($link_target); ?>">
              <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-6">
                <span class="icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 17.002C21.9996 18.3696 21.5321 19.696 20.675 20.7616C19.8179 21.8273 18.6226 22.5683 17.287 22.862L16.649 20.948C17.2332 20.8518 17.7888 20.6271 18.2758 20.2903C18.7627 19.9534 19.1689 19.5128 19.465 19H17C16.4696 19 15.9609 18.7893 15.5858 18.4142C15.2107 18.0391 15 17.5304 15 17V13C15 12.4696 15.2107 11.9609 15.5858 11.5858C15.9609 11.2107 16.4696 11 17 11H19.938C19.694 9.0669 18.7529 7.28927 17.2914 6.00068C15.8299 4.71208 13.9484 4.00108 12 4.00108C10.0516 4.00108 8.17007 4.71208 6.70857 6.00068C5.24708 7.28927 4.30603 9.0669 4.062 11H7C7.53043 11 8.03914 11.2107 8.41421 11.5858C8.78929 11.9609 9 12.4696 9 13V17C9 17.5304 8.78929 18.0391 8.41421 18.4142C8.03914 18.7893 7.53043 19 7 19H4C3.46957 19 2.96086 18.7893 2.58579 18.4142C2.21071 18.0391 2 17.5304 2 17V12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12V17.002Z"/>
                  </svg>
                </span>
                <span><?php echo esc_html ($link_title); ?></span>
              </a>
            </div>
          <?php endif; ?>
        </div>
      </section>

    <?php elseif (get_row_layout () == 'portfolio'): ?>
      <?php
      $make_tax = get_sub_field ('portfolio_category');
      $portfolio_posts = get_sub_field ('portfolio_objects');
      // Push posts IDs to new array
      $identifiers = array();
      if (( $make_tax ) || ( $portfolio_posts )) {
        if ($make_tax) {
          $args_1 = get_posts (array(
              'post_type' => 'portfolio',
              'post_count' => -1,
              'tax_query' => array(
                  array(
                      'taxonomy' => 'make',
                      'field' => 'term_id',
                      'terms' => $make_tax,
                  )
              ),
          ));
          foreach ($args_1 as $post) {
            array_push ($identifiers, $post->ID);
          }
        }
        if ($portfolio_posts) {
          // Second query, specific posts query
          $args_2 = get_posts (array(
              'post_type' => 'portfolio',
              'post_count' => -1,
              'include' => $portfolio_posts,
          ));
          foreach ($args_2 as $post) {
            array_push ($identifiers, $post->ID);
          }
        }
      }

      // New query
      $query = new WP_Query(array(
          'post_type' => 'portfolio',
          'post_status' => 'publish',
          'post_count' => -1,
          'post__in' => array_unique ($identifiers),
      ));

      if ($query->have_posts ()) :?>
        <!--SPECIALIST REVIEWS-->
        <section class="s-specialists-reviews ms-section">
          <div class="section-bg">
            <img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-01.png" loading="lazy" alt="">
          </div>
          <div class="cn cn--big">
            <div class="section-heading">
              <div class="decorated-title decorated-title--column-center">
                <div class="small-title small-title--white">Portfolio</div>
                <div class="line-decor line-decor--red"></div>
              </div>
              <h2 class="title h1"><?php echo get_sub_field ('portfolio_title'); ?></h2>
              <div class="subtitle"><?php echo get_sub_field ('portfolio_title'); ?></div>
            </div>

            <div class="s-specialists-reviews__list">
              <?php while ($query->have_posts ()) :
                $query->the_post (); ?>

                <div class="sr-item">
                  <div class="sr-item__img">
                    <?php $image_repeater = get_field ('overview_image'); ?>
                    <?php if ($image_repeater) { ?>
                      <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                           loading="lazy" alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                    <?php } ?>
                  </div>
                  <div class="sr-item__content">
                    <h3 class="title h2"><?php echo get_the_title (); ?></h3>
                    <div class="tags">
	                    <?php
	                    $term_list = wp_get_post_terms ($post->ID, 'portfolio_category', ['fields' => 'all']);
	                    // Виводимо назву первинної категорії
	                    foreach ($term_list as $term_primary) {
		                    $primary_category = get_post_meta ($post->ID, '_yoast_wpseo_primary_portfolio_category', true);
		                    if ($primary_category == $term_primary->term_id) {
			                    echo '<div class="tag">' .esc_html ($term_primary->name). '</div>';
			                    break; // Припиняємо цикл після знаходження первинної категорії
		                    }
	                    }?>
                    </div>
                    <div class="desc"><?php echo get_field ('preview_description'); ?></div>
                    <a href="<?php the_permalink (); ?>" class="btn btn-3">
                      <span>Read more</span>
                      <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                          <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                        </svg>
                      </span>
                    </a>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
          </div>
        </section>
      <?php endif;
      wp_reset_postdata (); ?>


    <?php elseif (get_row_layout () == 'experienced'): ?>
      <!--BANNER-->
      <section class="s-banner-2 ms-section">
        <div class="section-bg">
          <img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-03.png" loading="lazy" alt=""></div>
        <div class="cn">
          <div class="s-banner-2__inner">
            <div class="s-banner-2__left">
              <div class="decorated-title decorated-title--column-left">
                <div class="small-title small-title--white"><?php echo get_sub_field ('experienced_title'); ?></div>
                <div class="line-decor line-decor--white"></div>
              </div>
              <h2 class="title h1"><?php echo get_sub_field ('experienced_title'); ?></h2>
            </div>
            <div class="s-banner-2__right">
              <div class="numbers">
                <?php if (have_rows ('experienced_items')): ?>
                  <?php while (have_rows ('experienced_items')) : the_row (); ?>
                    <div class="item">
                      <div class="title">
                        <?php $image_repeater = get_sub_field ('icon'); ?>
                        <div class="icon">
                          <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                               alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                        </div>
                        <div><?php echo get_sub_field ('number'); ?></div>
                      </div>
                      <div class="desc"><?php echo get_sub_field ('name'); ?></div>
                    </div>
                  <?php endwhile; ?>
                <?php endif; ?>
              </div>
              <div class="text"><?php echo get_sub_field ('experienced_text'); ?></div>
              <?php
              $link = get_sub_field ('experienced_button');
              if ($link):
                $link_url = $link[ 'url' ];
                $link_title = $link[ 'title' ];
                $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
                ?>
                <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-5" <?php echo esc_attr ($link_target); ?>>
                  <span> <?php echo esc_html ($link_title); ?></span>
                  <span class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                      <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                    </svg>
                  </span>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'we_work'): ?>
      <!--COOPERATION-->
      <section class="s-cooperation ms-section">
        <div class="cn cn--small">
          <div class="section-heading">
            <div class="decorated-title decorated-title--column-center">
              <div class="small-title small-title--gray"><?php echo get_sub_field ('we_work_title'); ?></div>
              <div class="line-decor line-decor--red"></div>
            </div>
            <h2 class="title h1"><?php echo get_sub_field ('we_work_title'); ?></h2>
            <div class="subtitle"><?php echo get_sub_field ('we_work_text'); ?></div>
          </div>
          <div class="partners-logos">
            <?php if (have_rows ('we_work_logos')): ?>
              <?php while (have_rows ('we_work_logos')) : the_row (); ?>
                <?php $image_repeater = get_sub_field ('image'); ?>
                <div class="item">
                  <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                       alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                </div>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>

          <div class="swiper cooperation-slider">
            <div class="swiper-wrapper">
              <?php if (have_rows ('we_work_reviews')): ?>
                <?php while (have_rows ('we_work_reviews')) : the_row (); ?>
                  <?php $image_repeater = get_sub_field ('image'); ?>
                  <div class="swiper-slide">
                    <div class="item">
                      <div class="img">
                        <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                             alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                      </div>
                      <div class="subtitle"><?php echo get_sub_field ('subtitle'); ?></div>
                      <div class="title"><?php echo get_sub_field ('title'); ?></div>
                      <div><?php echo get_sub_field ('name'); ?></div>
                      <div><?php echo get_sub_field ('text'); ?></div>
                    </div>
                  </div>
                <?php endwhile; ?>
              <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>

    <?php elseif (get_row_layout () == 'reviews'): ?>
    <?php echo get_template_part ('includes/content', 'reviews'); ?>

    <?php elseif (get_row_layout () == 'faq'): ?>
      <!--KNOWLEDGE variant 3-->
      <section class="s-knowledge s-knowledge--variant-3 ms-section">
        <div class="cn">
          <div class="section-heading section-heading--simple">
            <h2 class="title h1"><?php echo get_sub_field ('faq_title'); ?></h2>
            <div class="subtitle"><?php echo get_sub_field ('faq_subtitle'); ?></div>
          </div>
          <div class="acc">
            <?php if (have_rows ('faq_accordion')): ?>
              <?php while (have_rows ('faq_accordion')) : the_row (); ?>
                <div class="acc-item">
                  <div class="acc-head"><?php echo get_sub_field ('name'); ?></div>
                  <div class="acc-body">
                    <div class="inner">
                      <div class="text"><?php echo get_sub_field ('content'); ?></div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </div>
      </section>
    <?php endif;
    // End loop.
  endwhile;
// No value.
else :
  // Do something...
endif; ?>

<section class="s-knowledge s-knowledge--variant-3 ms-section">
  <div class="cn">
    <div class="b-cta">
      <div class="title h1">Still have questions?</div>
      <div class="subtitle">Contact us for further assistance.</div>
      <a href="/staging/contact-us/" class="btn btn-6">
        <span class="icon">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M22 17.002C21.9996 18.3696 21.5321 19.696 20.675 20.7616C19.8179 21.8273 18.6226 22.5683 17.287 22.862L16.649 20.948C17.2332 20.8518 17.7888 20.6271 18.2758 20.2903C18.7627 19.9534 19.1689 19.5128 19.465 19H17C16.4696 19 15.9609 18.7893 15.5858 18.4142C15.2107 18.0391 15 17.5304 15 17V13C15 12.4696 15.2107 11.9609 15.5858 11.5858C15.9609 11.2107 16.4696 11 17 11H19.938C19.694 9.0669 18.7529 7.28927 17.2914 6.00068C15.8299 4.71208 13.9484 4.00108 12 4.00108C10.0516 4.00108 8.17007 4.71208 6.70857 6.00068C5.24708 7.28927 4.30603 9.0669 4.062 11H7C7.53043 11 8.03914 11.2107 8.41421 11.5858C8.78929 11.9609 9 12.4696 9 13V17C9 17.5304 8.78929 18.0391 8.41421 18.4142C8.03914 18.7893 7.53043 19 7 19H4C3.46957 19 2.96086 18.7893 2.58579 18.4142C2.21071 18.0391 2 17.5304 2 17V12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12V17.002Z"/>
          </svg>
        </span>
        <span>Contact us</span>
      </a>
    </div>
  </div>
</section>

<section class="ms-section">
  <div class="cn">
    <?php the_content (); ?>
  </div>
</section>

<?php get_footer (); ?>
