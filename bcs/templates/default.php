<?php get_header ();
/* Template Name: Flexible content Template */
?>

<?php
// Check value exists.
if (have_rows ('default_content')):
  $i = 0;
  // Loop through rows.
  while (have_rows ('default_content')) : the_row ();
    $i++;
    // Case: Paragraph layout.
    if (get_row_layout () == 'technical_data'):?>
      <!--HERO variant 1-->
      <section class="s-hero s-hero--variant-1 ms-section">
        <div class="cn cn--big">
          <div class="inner-content">
            <?php $image_repeater = get_sub_field ('technical_data_image'); ?>
            <div class="inner-content__img"><img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                                                 loading="lazy"
                                                 alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>"></div>
            <div class="inner-content__text">
              <div class="section-heading">
                <h1 class="title h1"><?php echo get_sub_field ('technical_data_title'); ?></h1>
                <h2 class="subtitle h2"><?php echo get_sub_field ('technical_data_subtitle'); ?></h2>
              </div>
              <div class="text">
                <div class="title"><?php echo get_sub_field ('technical_data_list_title'); ?></div>
                <ul>
                  <?php if (have_rows ('technical_data_list')): ?>
                    <?php while (have_rows ('technical_data_list')) : the_row (); ?>
                      <li><?php echo get_sub_field ('technical_data_name'); ?>
                        <span><?php echo get_sub_field ('technical_data_specification'); ?></span>
                      </li>
                    <?php endwhile; ?>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'left_side_image_preview'): ?>
      <!--HERO variant 2-->
      <section class="s-hero s-hero--variant-2 ms-section">
        <div class="cn cn--big">
          <div class="inner-content">
            <?php $image_repeater = get_sub_field ('left_side_image_preview_image'); ?>
            <div class="inner-content__img"><img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"

                                                 alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>"></div>
            <div class="empty"></div>
            <div class="inner-content__text">
              <div class="section-heading">
                <h1 class="title h1"><?php echo get_sub_field ('left_side_image_preview_title'); ?></h1>
                <h2 class="subtitle h2"><?php echo get_sub_field ('left_side_image_preview_subtitle'); ?> </h2>
              </div>
              <div class="text">
                <?php echo get_sub_field ('left_side_image_preview_text'); ?>
              </div>
            </div>
          </div>
        </div>
      </section>


    <?php elseif (get_row_layout () == 'right_side_image_preview'): ?>
      <!--HERO variant 3-->
      <section class="s-hero s-hero--variant-3 ms-section">
        <div class="cn cn--big">
          <div class="inner-content">
            <?php $image_repeater = get_sub_field ('right_side_image_preview_image'); ?>
            <div class="inner-content__img"><img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                                                 loading="lazy"
                                                 alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>"></div>
            <div class="inner-content__text">
              <div class="section-heading">
                <h1 class="title h1"><?php echo get_sub_field ('right_side_image_preview_title'); ?></h1>
                <h2 class="subtitle h2"><?php echo get_sub_field ('right_side_image_preview_subtitle'); ?> </h2>
              </div>
              <div class="text">
                <?php echo get_sub_field ('right_side_image_preview_text'); ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'overview_without_image'): ?>
      <!--OVERVIEW variant 1-->
      <section class="s-overview s-overview--variant-1 ms-section">
        <div class="cn">
          <div class="section-heading">
            <h2 class="title h1"><?php echo get_sub_field ('overview_without_image_title'); ?></h2>
          </div>
          <div class="inner-content">
            <div class="inner-content__text">
              <div class="text"><?php echo get_sub_field ('overview_without_image_text'); ?></div>
              <?php
              $link = get_sub_field ('overview_without_image_button');
              if ($link):
                $link_url = $link[ 'url' ];
                $link_title = $link[ 'title' ];
                $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
                ?>

                <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-2"
                   target="<?php echo esc_attr ($link_target); ?>">
                  <span><?php echo esc_html ($link_title); ?></span>
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
    <?php elseif (get_row_layout () == 'overview_left_side_image'): ?>
      <!--OVERVIEW variant 2-->
      <section class="s-overview s-overview--variant-2 ms-section">
        <div class="cn">
          <div class="section-heading">
            <h2 class="title h1"><?php echo get_sub_field ('overview_left_side_image_title'); ?></h2>
          </div>
          <div class="inner-content">
            <?php $image_repeater = get_sub_field ('overview_left_side_image'); ?>
            <div class="inner-content__img"><img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                                                 loading="lazy"
                                                 alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>"></div>
            <div class="inner-content__text">
              <div class="text"><?php echo get_sub_field ('overview_left_side_image_text'); ?></div>
              <?php
              $link = get_sub_field ('overview_left_side_image_link');
              if ($link):
                $link_url = $link[ 'url' ];
                $link_title = $link[ 'title' ];
                $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
                ?>

                <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-2"
                   target="<?php echo esc_attr ($link_target); ?>">
                  <span><?php echo esc_html ($link_title); ?></span>
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
    <?php elseif (get_row_layout () == 'overview_right_side_image'): ?>
      <!--OVERVIEW variant 3-->
      <section class="s-overview s-overview--variant-3 ms-section">
        <div class="cn">
          <div class="section-heading">
            <h2 class="title h1"><?php echo get_sub_field ('overview_right_side_image_title'); ?></h2>
          </div>
          <div class="inner-content">
            <?php $image_repeater = get_sub_field ('overview_right_side_image'); ?>
            <div class="inner-content__img"><img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                                                 loading="lazy"
                                                 alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>"></div>
            <div class="inner-content__text">
              <div class="text"><?php echo get_sub_field ('overview_right_side_image_text'); ?></div>
              <?php
              $link = get_sub_field ('overview_right_side_image_link');
              if ($link):
                $link_url = $link[ 'url' ];
                $link_title = $link[ 'title' ];
                $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
                ?>

                <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-2"
                   target="<?php echo esc_attr ($link_target); ?>">
                  <span><?php echo esc_html ($link_title); ?></span>
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
    <?php elseif (get_row_layout () == 'overview_full_width_image'): ?>
      <!--OVERVIEW variant 4-->
      <section class="s-overview s-overview--variant-4 ms-section">
        <div class="cn cn--small">
          <div class="section-heading">
            <h2 class="title h1"><?php echo get_sub_field ('overview_full_width_image_title'); ?></h2>
          </div>
          <div class="inner-content">
            <?php $image_repeater = get_sub_field ('overview_full_width_image'); ?>
            <div class="inner-content__img"><img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                                                 loading="lazy"
                                                 alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>"
                                                 loading="lazy"></div>

            <div class="inner-content__text">
              <div class="text"><?php echo get_sub_field ('overview_full_width_image_text'); ?></div>
              <?php
              $link = get_sub_field ('overview_full_width_image_link');
              if ($link):
                $link_url = $link[ 'url' ];
                $link_title = $link[ 'title' ];
                $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
                ?>

                <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-6"
                   target="<?php echo esc_attr ($link_target); ?>">
            <span class="icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 17.002C21.9996 18.3696 21.5321 19.696 20.675 20.7616C19.8179 21.8273 18.6226 22.5683 17.287 22.862L16.649 20.948C17.2332 20.8518 17.7888 20.6271 18.2758 20.2903C18.7627 19.9534 19.1689 19.5128 19.465 19H17C16.4696 19 15.9609 18.7893 15.5858 18.4142C15.2107 18.0391 15 17.5304 15 17V13C15 12.4696 15.2107 11.9609 15.5858 11.5858C15.9609 11.2107 16.4696 11 17 11H19.938C19.694 9.0669 18.7529 7.28927 17.2914 6.00068C15.8299 4.71208 13.9484 4.00108 12 4.00108C10.0516 4.00108 8.17007 4.71208 6.70857 6.00068C5.24708 7.28927 4.30603 9.0669 4.062 11H7C7.53043 11 8.03914 11.2107 8.41421 11.5858C8.78929 11.9609 9 12.4696 9 13V17C9 17.5304 8.78929 18.0391 8.41421 18.4142C8.03914 18.7893 7.53043 19 7 19H4C3.46957 19 2.96086 18.7893 2.58579 18.4142C2.21071 18.0391 2 17.5304 2 17V12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12V17.002Z"/>
              </svg>
            </span>
                  <span><?php echo esc_html ($link_title); ?></span>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'video_right_side'): ?>
      <!--VIDEO variant 1-->
      <section class="s-video s-video--variant-1 ms-section">
        <div class="cn">
          <div class="inner-content">
            <div class="inner-content__text">
              <div class="section-heading">
                <h2 class="title h1"><?php echo get_sub_field ('video_right_side_title'); ?></h2>
              </div>
              <div class="text"><?php echo get_sub_field ('video_right_side_text'); ?></div>
            </div>
            <div class="inner-content__media">
              <!--<div class="img"><img src="images/img-04.jpg" loading="lazy" alt=""></div>-->
              <div class="video">
                <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/<?php echo get_sub_field ('video_right_side_video'); ?>"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'video_left_side'): ?>
      <!--VIDEO variant 2-->
      <section class="s-video s-video--variant-2 ms-section">
        <div class="cn">
          <div class="inner-content">
            <div class="inner-content__text">
              <div class="section-heading">
                <h2 class="title h1"><?php echo get_sub_field ('video_left_side_title'); ?></h2>
              </div>
              <div class="text"><?php echo get_sub_field ('video_left_side_text'); ?></div>
            </div>
            <div class="inner-content__media">
              <div class="video">
                <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/<?php echo get_sub_field ('video_left_side_video'); ?>"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'video_full_width'): ?>
      <!--VIDEO variant 3-->
      <section class="s-video s-video--variant-3 ms-section">
        <div class="cn cn--small">
          <div class="inner-content">
            <div class="inner-content__text">
              <div class="section-heading">
                <h2 class="title h1"><?php echo get_sub_field ('video_full_width_title'); ?></h2>
              </div>
              <div class="text"><?php echo get_sub_field ('video_full_width_text'); ?></div>
            </div>
            <div class="inner-content__media">
              <div class="video">
                <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/<?php echo get_sub_field ('video_full_width_video'); ?>"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'portfolio'): ?>
      <!--SPLIT-->
      <section class="s-split ms-section">
        <div class="cn">
          <div class="section-heading section-heading--simple">
            <h2 class="title h1"><?php echo get_sub_field ('portfolio_title'); ?></h2>
            <div class="subtitle"><?php echo get_sub_field ('portfolio_subtitle'); ?></div>
          </div>

          <div class="s-split__list">
            <?php
            $post_ID = $post->ID;
            $make_tax = get_sub_field ('portfolio_category');
            $portfolio_posts = get_sub_field ('portfolio_posts');
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
            } else {

              $terms = wp_get_object_terms ($post->ID, 'make', array('orderby' => 'term_id', 'order' => 'ASC'));
              if (!empty($terms)) :
                $project = array();
                foreach ($terms as $term) {
                  $project[] = $term->term_id;
                } endif;
              $args_3 = get_posts (array(
                  'post_type' => 'portfolio',
                  'post_count' => -1,
                  'tax_query' => array(
                      array(
                          'taxonomy' => 'make',
                          'field' => 'term_id',
                          'terms' => $project[ 1 ],
                      )
                  ),
              ));
              foreach ($args_3 as $post) {
                array_push ($identifiers, $post->ID);
              }
            }

            // New query
            $query = new WP_Query(array(
                'post_type' => 'portfolio',
                'post_status' => 'publish',
                'post_count' => -1,
                'post__in' => array_unique ($identifiers),
            ));

            if ($query->have_posts ()) :

              while ($query->have_posts ()) :

                $query->the_post (); ?>
                <div class="split-item">
                  <div class="split-item__img">
                    <?php $image_repeater = get_field ('overview_image'); ?>
                    <?php if ($image_repeater) { ?>
                      <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                           loading="lazy"
                           alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                    <?php } ?>
                  </div>
                  <div class="split-item__content">
                    <h3 class="title h2"><?php the_title (); ?></h3>
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
                    <a href="<?php the_permalink (); ?>" class="btn btn-2">
                      <span>Read more</span>
                      <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                  <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                </svg>
              </span>
                    </a>
                  </div>
                </div>
              <?php endwhile;

            endif;
            wp_reset_postdata (); ?>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'services_with_image'): ?>
      <!--THREE COLUMN variant 1-->
      <section class="s-three-column s-three-column--variant-1 ms-section">
        <div class="cn">
          <div class="section-heading section-heading--simple">
            <h2 class="title h1"><?php echo get_sub_field ('services_with_Image_title'); ?></h2>
            <div class="subtitle"><?php echo get_sub_field ('services_with_Image_subtitle'); ?></div>
          </div>
          <div class="s-three-column__list">

            <div class="item">
              <div class="img"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/img-02.jpg"
                                    loading="lazy" alt=""></div>
              <h3 class="title">Brake Caliper Refurbishment Front and Rear Pair</h3>
              <div class="desc">Our team specializes in refurbishing brake calipers to restore their
                performance
                and appearance.
              </div>
              <a href="#" class="btn btn-2">
                <span>Read more</span>
                <span class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
              </svg>
            </span>
              </a>
            </div>

            <div class="item">
              <div class="img"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/img-02.jpg"
                                    loading="lazy" alt=""></div>
              <h3 class="title">Engineering and ReManufacture</h3>
              <div class="desc">We have incredible engineering capabilities at BCS. Aside from our on-site
                engineer with almost 40 years experience in manual turning, milling,
              </div>
              <a href="#" class="btn btn-2">
                <span>Read more</span>
                <span class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
              </svg>
            </span>
              </a>
            </div>
            <div class="item">
              <div class="img"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/img-02.jpg"
                                    loading="lazy" alt=""></div>
              <h3 class="title">Caliper Painting</h3>
              <div class="desc">With our High-End caliper painting service, we can provide all OEM colours for
                Brembo brake calipers.
              </div>
              <a href="#" class="btn btn-2">
                <span>Read more</span>
                <span class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
              </svg>
            </span>
              </a>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'services_without_image'): ?>
      <!--THREE COLUMN variant 2-->
      <section class="s-three-column s-three-column--variant-2 ms-section">
        <div class="cn">
          <div class="section-heading section-heading--simple">
            <h2 class="title h1"><?php echo get_sub_field ('services_without_image_title'); ?></h2>
            <div class="subtitle"><?php echo get_sub_field ('services_without_image_subtitle'); ?></div>
          </div>
          <div class="s-three-column__list">
            <div class="item">
              <div class="img"><img
                        src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/icon-01.svg"
                        loading="lazy" alt=""></div>
              <h3 class="title">Customization</h3>
              <div class="desc">Our team specializes in refurbishing brake calipers to restore their
                performance
                and appearance.
              </div>
            </div>
            <div class="item">
              <div class="img"><img
                        src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/icon-02.svg"
                        loading="lazy" alt=""></div>
              <h3 class="title">Worldwide Shipping</h3>
              <div class="desc">We offer convenient worldwide shipping options to ensure your refurbished
                brake
                calipers reach you no matter where you are.
              </div>
            </div>
            <div class="item">
              <div class="img"><img
                        src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/icon-03.svg"
                        loading="lazy" alt=""></div>
              <h3 class="title">Product Customization</h3>
              <div class="desc">85% of jobs completed by our specializes within 24 hours</div>
            </div>
          </div>


          <div class="section-btn">
            <?php
            $link = get_sub_field ('services_without_image_button');
            if ($link):
              $link_url = $link[ 'url' ];
              $link_title = $link[ 'title' ];
              $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
              ?>

              <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-6"
                 target="<?php echo esc_attr ($link_target); ?>">
          <span class="icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M22 17.002C21.9996 18.3696 21.5321 19.696 20.675 20.7616C19.8179 21.8273 18.6226 22.5683 17.287 22.862L16.649 20.948C17.2332 20.8518 17.7888 20.6271 18.2758 20.2903C18.7627 19.9534 19.1689 19.5128 19.465 19H17C16.4696 19 15.9609 18.7893 15.5858 18.4142C15.2107 18.0391 15 17.5304 15 17V13C15 12.4696 15.2107 11.9609 15.5858 11.5858C15.9609 11.2107 16.4696 11 17 11H19.938C19.694 9.0669 18.7529 7.28927 17.2914 6.00068C15.8299 4.71208 13.9484 4.00108 12 4.00108C10.0516 4.00108 8.17007 4.71208 6.70857 6.00068C5.24708 7.28927 4.30603 9.0669 4.062 11H7C7.53043 11 8.03914 11.2107 8.41421 11.5858C8.78929 11.9609 9 12.4696 9 13V17C9 17.5304 8.78929 18.0391 8.41421 18.4142C8.03914 18.7893 7.53043 19 7 19H4C3.46957 19 2.96086 18.7893 2.58579 18.4142C2.21071 18.0391 2 17.5304 2 17V12C2 6.477 6.477 2 12 2C17.523 2 22 6.477 22 12V17.002Z"/>
            </svg>
          </span>
                <span><?php echo esc_html ($link_title); ?></span>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'products'): ?>
      <!--PRODUCTS-->
      <section class="s-products ms-section">
        <div class="cn">
          <div class="section-heading section-heading--simple">
            <h2 class="title h1"><?php echo get_sub_field ('products_title'); ?></h2>
            <div class="subtitle"><?php echo get_sub_field ('products_subtitle'); ?></div>
          </div>
          <div class="products-list">
            <?php
            $featured_posts = get_sub_field ('products');
            if ($featured_posts): ?>

              <?php foreach ($featured_posts as $post):

                // Setup this post for WP functions (variable must be named $post).
                setup_postdata ($post); ?>
                <div class="product-card">
                  <div class="product-card__img"><img
                            src="<?php echo get_template_directory_uri (); ?>/assets/images/img-03.jpg"
                            loading="lazy" alt=""></div>
                  <div class="product-card__content">
                    <h3 class="title">Porsche 993 911 front brake caliper repair kit for Brembo</h3>
                    <div class="subtitle">2004-2011</div>
                    <div class="btn-group">
                      <a href="#" class="btn btn-2">From $6.95</a>
                      <a href="#" class="btn btn-2">From $6.95</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>

              <?php
              // Reset the global post object so that the rest of the page works correctly.
              wp_reset_postdata (); ?>
            <?php endif; ?>

          </div>
          <div class="section-btn">
            <?php
            $link = get_sub_field ('products_button');
            if ($link):
              $link_url = $link[ 'url' ];
              $link_title = $link[ 'title' ];
              $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
              ?>

              <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-1"
                 target="<?php echo esc_attr ($link_target); ?>"><?php echo esc_html ($link_title); ?></a>
            <?php endif; ?>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'reviews'): ?>
      <?php echo get_template_part ('includes/content', 'reviews'); ?>
    <?php elseif (get_row_layout () == 'trim_specifications'): ?>
      <!--KNOWLEDGE variant 1-->
      <section class="s-knowledge s-knowledge--variant-1 ms-section">
        <div class="cn">
          <div class="acc">
            <?php if (have_rows ('trim_specifications')): ?>
              <?php while (have_rows ('trim_specifications')) : the_row (); ?>
                <div class="acc-item">
                  <div class="acc-head"><?php echo get_sub_field ('trim_specifications_title'); ?></div>
                  <div class="acc-body">
                    <div class="inner">
                      <div class="text">
                        <ul>
                          <?php if (have_rows ('left_side_trim_specifications')): ?>
                            <?php while (have_rows ('left_side_trim_specifications')) : the_row (); ?>
                              <li>
                                <span><?php echo get_sub_field ('name'); ?></span><span><?php echo get_sub_field ('specification'); ?></span>
                              </li>
                            <?php endwhile; ?>
                          <?php endif; ?>
                        </ul>
                        <ul>
                          <?php if (have_rows ('Right_side_trim_specifications')): ?>
                            <?php while (have_rows ('Right_side_trim_specifications')) : the_row (); ?>
                              <li>
                                <span><?php echo get_sub_field ('name'); ?></span><span><?php echo get_sub_field ('specification'); ?></span>
                              </li>
                            <?php endwhile; ?>
                          <?php endif; ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>


          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'faq'): ?>
      <!--KNOWLEDGE variant 3-->
      <section class="s-knowledge s-knowledge--variant-3 ms-section">
        <div class="cn">
          <div class="section-heading section-heading--simple">
            <h2 class="title h1"><?php echo get_sub_field ('faq_title'); ?></h2>
            <div class="subtitle"><?php echo get_sub_field ('faq_subtitle'); ?></div>
          </div>
          <div class="acc">
            <?php if (have_rows ('faq_repeater')): ?>
              <?php while (have_rows ('faq_repeater')) : the_row (); ?>
                <div class="acc-item">
                  <div class="acc-head"><?php echo get_sub_field ('question'); ?></div>
                  <div class="acc-body">
                    <div class="inner">
                      <div class="text"><?php echo get_sub_field ('answer'); ?></div>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>

          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'overview_with_subtitle'): ?>

      <!--OVERVIEW variant 5-->
      <section class="s-overview s-overview--variant-5 ms-section">
        <div class="cn">
          <div class="inner-content">
            <?php $image_repeater = get_sub_field ('overview_full_width_image'); ?>
            <div class="inner-content__img"><img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                                                 loading="lazy"
                                                 alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>"
                                                 loading="lazy"></div>
            <div class="inner-content__text">
              <div class="section-heading">
                <h2 class="title h1"><?php echo get_sub_field ('overview_full_width_image_title'); ?></h2>
                <h3 class="subtitle h2"><?php echo get_sub_field ('overview_full_width_image_subtitle'); ?></h3>
              </div>
              <div class="text"><?php echo get_sub_field ('overview_full_width_image_text'); ?></div>
              <?php
              $link = get_sub_field ('overview_full_width_image_link');
              if ($link):
                $link_url = $link[ 'url' ];
                $link_title = $link[ 'title' ];
                $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
                ?>

                <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-2"
                   target="<?php echo esc_attr ($link_target); ?>">
            <span class="icon">
             <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
              </svg>
            </span>
                  <span><?php echo esc_html ($link_title); ?></span>
                </a>
              <?php endif; ?>
            </div>
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
<!--KNOWLEDGE variant 3-->
<section class="s-knowledge s-knowledge--variant-3 ms-section">
  <div class="cn">
    <div class="b-cta">
      <div class="title h1">Still have questions?</div>
      <div class="subtitle">Contact us for further assistance.</div>
      <a href="#" class="btn btn-6">
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


<?php get_footer (); ?>
