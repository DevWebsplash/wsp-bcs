<?php

/*
Template Name: ACF Template
Template Post Type: Portfolio
*/

get_header ();
?>
  <!--HERO variant 2-->
  <section class="s-hero s-hero--variant-2 ms-section">
    <div class="cn cn--big">
      <div class="inner-content">
        <div class="inner-content__img">
          <?php $image_repeater = get_field ('overview_image'); ?>
          <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
               alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
        </div>
        <div class="empty"></div>
        <div class="inner-content__text">
          <div class="section-heading">
            <?php
            echo '<h1 class="title h1">';
            // Отримуємо об'єкт посту з полем 'trim'
            $featured_post = get_field ('trim');
            // Отримуємо терміни таксономії 'make' для посту з полем 'trim'
            $terms = wp_get_object_terms ($featured_post->ID, 'make', [
                'orderby' => 'term_id',
                'order' => 'ASC'
            ]);

            if (!empty($terms)) {
              $project = [];
              foreach ($terms as $term) {
                $project[] = esc_html ($term->name);
              }
              // Виводимо перші два елементи масиву
              if (isset($project[ 0 ])) echo $project[ 0 ] . ' ';
              if (isset($project[ 1 ])) echo $project[ 1 ] . ' ';
            }

            // Виводимо заголовок посту 'trim'
            if ($featured_post) {
              echo esc_html ($featured_post->post_title);
            }
            // Початок заголовка
            echo '  ';
            // Отримуємо терміни таксономії 'portfolio_category'
            $term_list = wp_get_post_terms ($post->ID, 'portfolio_category', ['fields' => 'all']);
            // Виводимо назву первинної категорії
            foreach ($term_list as $term_primary) {
              $primary_category = get_post_meta ($post->ID, '_yoast_wpseo_primary_portfolio_category', true);
              if ($primary_category == $term_primary->term_id) {
                echo esc_html ($term_primary->name);
                break; // Припиняємо цикл після знаходження первинної категорії
              }
            }
            echo ' for ' . esc_html (get_field ('first_name')) . ' in ';
            $terms = wp_get_object_terms ($post->ID, 'location', array('orderby' => 'term_id', 'order' => 'ASC'));
            if (!empty($terms)) :
              $project = array();
              foreach ($terms as $term) {
                $project[] = $term->name;
              } ?>
              <?php echo $project[ 0 ]; ?>
            <?php endif;
            echo ', ';

            echo get_the_date ('F Y'); // This will return and print the date in "Month Year" format


            echo '</h1>';
            ?>

          </div>
          <div class="info-1">
            <div class="item">
              <div class="icon"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/icon-07.svg"
                                     loading="lazy" alt="Project Status"></div>
              <div>
                <div class="title">Project Status</div>
                <div><?php echo get_field ('overview_project_status'); ?></div>
              </div>
            </div>
            <div class="item">
              <div class="icon"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/icon-08.svg"
                                     loading="lazy" alt="Location"></div>
              <div>
                <div class="title">Location</div>
                <div>
                  <?php
                  $terms = wp_get_object_terms ($post->ID, 'location', array('orderby' => 'term_id', 'order' => 'ASC'));
                  if (!empty($terms)) :
                    $project = array();
                    foreach ($terms as $term) {
                      $project[] = $term->name;
                    } ?>
                    <?php echo $project[ 0 ]; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="icon"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/icons/client_1.svg"
                                     loading="lazy" alt="client status"></div>
              <div>
                <div class="title">Client</div>
                <div><?php echo get_field ('is_business_or_private'); ?></div>
              </div>
            </div>
          </div>
          <div class="info-2">
            <div class="text">
              <p><?php if (get_field ('overview_project_status') == 'Completed') { ?>
                  Scroll below to see the before and after images and further information about the
                  <?php
                  $term_list = wp_get_post_terms ($post->ID, 'portfolio_category', ['fields' => 'all']);
                  foreach ($term_list as $term) {
                    if (get_post_meta ($post->ID, '_yoast_wpseo_primary_portfolio_category', true) == $term->term_id) {
                      // this is a primary category
                    }
                  }
                  ?> on these <?php $terms = wp_get_object_terms ($featured_post->ID, 'make', array('orderby' => 'term_id', 'order' => 'ASC'));
                  if (!empty($terms)) :
                    $project = array();
                    foreach ($terms as $term) {
                      $project[] = $term->name;
                    } ?>
                    <?php echo $project[ 0 ]; ?>
                  <?php endif; ?> brake calipers.
                <?php } else { ?>
                  We have not completed this job yet (or we just haven't uploaded the completion data yet), but scroll down to see what the job looked like and keep your eyes on this page if you'd like to see what these brakes look like once we're done.
                <?php } ?>
              </p>
            </div>

            <div class="block-title">Services used:</div>
            <?php $terms = wp_get_object_terms ($post->ID, 'portfolio_category', array('orderby' => 'term_id', 'order' => 'ASC'));
            if (!empty($terms)) :
              $project = array();
              foreach ($terms as $term) {
                $project_name = $term->name;
                $project_id = $term->term_id;
                ?>
                <div class="item">
                  <?php $image_repeater = get_field ('service_used_image', $term);
                  if ($image_repeater) { ?>
                    <div class="icon">
                      <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                           alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                    </div>
                  <?php } ?>
                  <div><?php echo $project_name; ?></div>
                </div>
              <?php } ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--OVERVIEW variant 1-->
  <section class="s-overview s-overview--variant-1 s-overview--variant-6 ms-section">
    <div class="cn">
      <div class="section-heading">
        <h2 class="title h1">Job information</h2>
      </div>
      <div class="inner-content">
        <div class="inner-content__text">
          <div class="desc">We recently completed a <?php
            $term_list = wp_get_post_terms ($post->ID, 'portfolio_category', ['fields' => 'all']);
            foreach ($term_list as $term_primary) {
              $primary_category = get_post_meta ($post->ID, '_yoast_wpseo_primary_portfolio_category', true);
              if ($primary_category == $term_primary->term_id) {
                echo esc_html ($term_primary->name);
                break;
              }
            } ?> project for <?php echo esc_html (get_field ('first_name')); ?>
            ’s <?php $featured_post = get_field ('trim');
            // Отримуємо терміни таксономії 'make' для посту з полем 'trim'
            $terms = wp_get_object_terms ($featured_post->ID, 'make', [
                'orderby' => 'term_id',
                'order' => 'ASC'
            ]);

            if (!empty($terms)) {
              $project = [];
              foreach ($terms as $term) {
                $project[] = esc_html ($term->name);
              }
              // Виводимо перші два елементи масиву
              if (isset($project[ 0 ])) echo $project[ 0 ] . ' ';
              if (isset($project[ 1 ])) echo $project[ 1 ] . ' ';
            }

            // Виводимо заголовок посту 'trim'
            if ($featured_post) {
              echo esc_html ($featured_post->post_title);
            } ?>
            in <?php $terms = wp_get_object_terms ($post->ID, 'location', array('orderby' => 'term_id', 'order' => 'ASC'));
            if (!empty($terms)) :
              $project = array();
              foreach ($terms as $term) {
                $project[] = $term->name;
              } ?>
              <?php echo $project[ 0 ]; ?>
            <?php endif; ?>.
            The brake caliper arrived
            in <?php if (get_field ('color_applied') == 'None') { ?><?php echo get_field ('color_of_work');
            } else {
              echo get_field ('color_applied');
            } ?> color and <?php echo get_field ('arrival_condition'); ?> condition, enabling us to efficiently perform
            the brake caliper repair while maintaining our high standards of quality.
            We ensure that all our brake caliper refurbishment services are backed by a Lifetime Warranty, giving our
            customers confidence in the durability and long-term performance of the work.
          </div>
          <div class="text">
            <ul>
              <?php if (get_field ('is_business_or_private')) { ?>
                <li>
                  <span><?php echo get_field ('calipers_refurbished_title'); ?> :</span>
                  <span><?php echo get_field ('calipers_refurbished'); ?></span>
                  <p><?php echo get_field ('calipers_refurbished_description'); ?></p>
                </li>
              <?php } ?>
              <?php if (get_field ('drop_off_date')) { ?>
	              <?php
	              $field = get_field_object('drop_off_date');
	              ?>
                <li>
                  <span><?php echo $field['label']; ?> :</span>
                  <span><?php echo $field['value']; ?></span>

                </li>
              <?php } ?>
              <?php if (get_field ('total_days_turnaround_time')) { ?>
	              <?php
	              $field = get_field_object('total_days_turnaround_time');
	              ?>
                <li>
                    <span> <?php echo $field['label']; ?> :</span>
                    <span><?php echo $field['value']; ?></span>
                    <p><?php echo get_field ('turnaround_times_description'); ?></p>
                </li>
              <?php } ?>
              <?php if (get_field ('ship_back_or_collection_date')) { ?>
                <li>
	                <?php
	                $field = get_field_object('ship_back_or_collection_date');
	                ?>
                    <span><?php echo $field['label']; ?> :</span>
                    <span><?php echo $field['value']; ?></span>

                </li>
              <?php } ?>
              <?php if (get_field ('color_applied')) { ?>
                <li>
                  <span><?php echo get_field ('color_applied_title'); ?> :</span>
                  <span><?php if (get_field ('color_applied') == 'None') { ?><?php echo get_field ('color_of_work');
                    } else {
                      echo get_field ('color_applied');
                    } ?></span>
                  <p><?php echo get_field ('color_description'); ?></p>
                </li>
              <?php } ?>
            </ul>
            <ul>
	            <?php if (get_field ('arrival_condition')) { ?>
                  <li>
                      <span><?php echo get_field ('arrival_condition_title'); ?> :</span>
                      <span><?php echo get_field ('arrival_condition'); ?></span>
                      <p><?php echo get_field ('arrival_condition_description'); ?></p>
                  </li>
	            <?php } ?>
              <?php if (get_field ('does_rear_caliper_have_handbrake_mechanism')) { ?>
                <li>
	                <?php
	                $field = get_field_object('does_rear_caliper_have_handbrake_mechanism');
	                ?>
                    <span><?php echo $field['label']; ?> :</span>
                    <span><?php echo $field['value']; ?></span>
                </li>
              <?php } ?>
              <?php if (get_field ('front_caliper_make')) { ?>
                <li>
	                <?php
	                $field = get_field_object('front_caliper_make');
	                ?>
                    <span><?php echo $field['label']; ?> :</span>
                    <span><?php echo $field['value']; ?></span>
                </li>
              <?php } ?>

              <?php if (get_field ('front_piston_count')) { ?>
                <li>
	                <?php
	                $field = get_field_object('front_piston_count');
	                ?>
                    <span><?php echo $field['label']; ?> :</span>
                    <span><?php echo $field['value']; ?></span>
                </li>
              <?php } ?>

              <?php if (get_field ('rear_caliper_make')) { ?>
                <li>
	                <?php
	                $field = get_field_object('rear_caliper_make');
	                ?>
                    <span><?php echo $field['label']; ?> :</span>
                    <span><?php echo $field['value']; ?></span>
                </li>
              <?php } ?>

              <?php if (get_field ('rear_piston_count')) { ?>
                <li>
	                <?php
	                $field = get_field_object('rear_piston_count');
	                ?>
                    <span><?php echo $field['label']; ?> :</span>
                    <span><?php echo $field['value']; ?></span>
                </li>
              <?php } ?>

            </ul>
          </div>
          <div class="text__fullWidth">
            <!--Engineering Services-->
            <?php if (has_term (153308, 'portfolio_category', get_the_ID ())) { ?>
              <div class="text-service" style="margin-top: 30px;">
                <h3 class="block-title h3"><?php echo get_field ('engineering_services_title'); ?></h3>
                <div class="desc"><?php echo get_field ('engineering_services_description'); ?></div>

                <ul class="info-list">
                  <?php if (have_rows ('engineering_services_list')): ?>
                    <?php while (have_rows ('engineering_services_list')) : the_row (); ?>
                      <li>
                        <div class="title"><?php echo get_sub_field ('list_title'); ?></div>
                        <div><?php echo get_sub_field ('list_description'); ?></div>
                      </li>
                    <?php endwhile; ?>
                  <?php endif; ?>
                </ul>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

    <!--Techologies variant 1-->
    <div class="s-knowledge s-knowledge--variant-1">
      <div class="cn">
        <div class="acc">
          <?php if (is_user_logged_in ()) { ?>
            <div class="acc-item">
              <div class="acc-head">Customer Information</div>
              <div class="acc-body">
                <div class="inner">
                  <div class="text">
                    <ul>
                      <?php if (get_field ('is_business_or_private')) { ?>
                        <li>
                          <span><?php echo get_field ('is_business_or_private_title'); ?> :</span>
                          <span><?php echo get_field ('is_business_or_private'); ?></span>
                        </li>
                      <?php } ?>
                      <?php if (get_field ('first_name_title')) { ?>
                        <li>
                          <span><?php echo get_field ('first_name_title'); ?> :</span>
                          <span><?php echo get_field ('first_name'); ?></span>
                        </li>
                      <?php } ?>
                      <?php if (get_field ('last_name')) { ?>
                        <li>
                          <span><?php echo get_field ('last_name_title'); ?> :</span>
                          <span><?php echo get_field ('last_name'); ?></span>
                        </li>
                      <?php } ?>
                      <?php if (get_field ('1st_line_address_title')) { ?>
                        <li>
                          <span><?php echo get_field ('1st_line_address_title'); ?> :</span>
                          <span><?php echo get_field ('1st_line_address'); ?></span>
                        </li>
                      <?php } ?>
                      <?php if (get_field ('2nd_line_addressshouldnt')) { ?>
                        <li>
                          <span><?php echo get_field ('2nd_line_addresss_title'); ?> :</span>
                          <span><?php echo get_field ('2nd_line_addressshouldnt'); ?></span>
                        </li>
                      <?php } ?>
                    </ul>
                    <ul>
                      <?php if (get_field ('company_name')) { ?>
                        <li>
                          <span><?php echo get_field ('company_name_title'); ?> :</span>
                          <span><?php echo get_field ('company_name'); ?></span>
                        </li>
                      <?php } ?>
                      <?php if (get_field ('town')) { ?>
                        <li>
                          <span><?php echo get_field ('town_title'); ?> :</span>
                          <span><?php echo get_field ('town'); ?></span>
                        </li>
                      <?php } ?>
                      <?php if (get_field ('city')) { ?>
                        <li><span><?php echo get_field ('city_title'); ?> :</span> <?php echo get_field ('city'); ?>
                          <span></span></li>
                      <?php } ?>
                      <?php if (get_field ('postal_code')) { ?>
                        <li>
                          <span><?php echo get_field ('postal_code_title'); ?> :</span>
                          <span><?php echo get_field ('postal_code'); ?></span>
                        </li>
                      <?php } ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
          <?php if (has_term (153309, 'portfolio_category', get_the_ID ())) { ?>
            <div class="acc-item">
            <div class="acc-head"><?php echo get_field ('parts_used_title'); ?></div>
            <div class="acc-body">
            <div class="inner">

            <!--Brake Caliper Parts Used-->
            <?php
            $featured_posts = get_field ('parts_used_products');
            if ($featured_posts): ?>
              <div class="text">
                <?php echo get_field ('parts_used_subtitle'); ?>
              </div>
              <div class="products-list">
                  <?php foreach ($featured_posts as $post):
                    // Setup this post for WP functions (variable must be named $post).
                    setup_postdata ($post);
                    $product = wc_get_product ($post->ID); ?>
                    <div class="product-card">
                      <div class="product-card__img">
                        <a href="<?php echo esc_url ($product->get_permalink ()); ?>">
                          <?php if ($product->get_image_id ()) : ?>
                            <img src="<?php echo wp_get_attachment_url ($product->get_image_id ()); ?>" loading="lazy"
                                 alt="<?php echo esc_attr ($product->get_name ()); ?>">
                          <?php else : ?>
                            <!-- Fallback static image -->
                            <img src="<?php echo esc_url (wc_placeholder_img_src ()); ?>" loading="lazy"
                                 alt="No image available">
                          <?php endif; ?>
                        </a>
                      </div>
                      <div class="product-card__content">
                        <h3 class="title"><?php echo esc_html ($product->get_name ()); ?></h3>
                        <div class="subtitle">
                          <?php
                          // Check if product is variable
                          if ($product->is_type ('variable')) {
                            // Get minimum and maximum prices for the variable product
                            echo $product->get_price_html (); // WooCommerce function to display variable product price range
                          } else {
                            // Display regular price for simple products
                            echo wc_price ($product->get_price ());
                          }
                          ?>
                        </div>
                        <div class="btn-group">
                          <?php
                          // Generate a Buy Now button with WooCommerce's "add_to_cart_url" function
                          $add_to_cart_url = esc_url ($product->add_to_cart_url ());
                          ?>
                          <a href="<?php echo $add_to_cart_url; ?>" class="btn btn-2"
                             data-product_id="<?php echo esc_attr ($product->get_id ()); ?>">
                            Buy Now </a>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
            </div>
            </div>
            </div>
            <?php endif;
            wp_reset_postdata (); ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>



<?php
// Check value exists.
if (have_rows ('flixble_content_portfolio')):
  $i = 0;
  // Loop through rows.
  while (have_rows ('flixble_content_portfolio')) : the_row ();
    $i++;
    // Case: Paragraph layout.
    if (get_row_layout () == 'video'):?>
      <!--VIDEO variant 4-->
      <section class="s-video s-video--variant-4 ms-section">
        <div class="cn">
          <div class="inner-content">
            <div class="inner-content__text">
              <div class="section-heading">
                <h2 class="title h1"><?php echo get_sub_field ('video_title'); ?></h2>
              </div>
              <div class="text"><?php echo get_sub_field ('video_description'); ?></div>
            </div>
            <div class="inner-content__media">
              <div class="video">
                <iframe width="560" height="315"
                        src="https://www.youtube.com/embed/<?php echo get_sub_field ('video'); ?>"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'steps'): ?>
      <!--STEPS-->
      <section class="s-steps ms-section">
        <div class="cn">
          <div class="section-heading">
            <h2 class="title h1"><?php echo get_sub_field ('steps_title'); ?></h2>
          </div>
          <div class="s-steps__list">
            <?php $i = 0;
            if (have_rows ('steps_repeater')): ?>
              <?php while (have_rows ('steps_repeater')) : the_row ();
                $i++; ?>
                <div class="s-steps__box">
                  <div class="block-title">
                    <h3 class="title h2"><?php echo get_sub_field ('title'); ?></h3>
                    <div class="date"><?php echo get_sub_field ('data'); ?></div>
                  </div>
                  <?php if (have_rows ('images')): ?>
                    <div class="images popup-gallery">
                      <?php while (have_rows ('images')) : the_row (); ?>
                        <?php $image_repeater = get_sub_field ('image'); ?>
                        <a href="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" class="img"
                           title="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                          <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                               alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                        </a>
                      <?php endwhile; ?>
                    </div>
                  <?php endif; ?>
                  <div class="overflow-text-cn">
                    <div class="overflow-text">
                      <div class="text"><?php echo get_sub_field ('text'); ?></div>
                    </div>
                    <button class="btn btn-2">
                      <span class="text-cn">
                        <span class="more-text">Show more</span>
                        <span class="less-text">Show less</span>
                      </span>
                      <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="8" viewBox="0 0 13 8" fill="none">
                          <path d="M2.1433 0.331642L6.54205 4.72081L10.9408 0.331642L12.2921 1.68289L6.54205 7.43289L0.792053 1.68289L2.1433 0.331642Z"/>
                        </svg>
                      </span>
                    </button>
                  </div>
                </div>
              <?php endwhile; ?>
            <?php endif; ?>
          </div>
        </div>
      </section>


    <?php elseif (get_row_layout () == 'overview'): ?>
      <!--OVERVIEW variant 1-->
      <section class="s-overview s-overview--variant-1 ms-section">
        <div class="cn">
          <div class="section-heading">
            <h2 class="title h1"><?php echo get_sub_field ('overview_title'); ?></h2>
          </div>
          <div class="inner-content">
            <div class="inner-content__text">
              <div class="text"><?php echo get_sub_field ('overview_content'); ?></div>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'comparison'): ?>
      <!--COMPARISON-->
      <section class="s-comparison ms-section">
        <div class="cn">
          <div class="inner-content">
            <div class="col">
              <div class="title h2">Before</div>
              <?php $image_repeater = get_sub_field ('comparison_before'); ?>
              <div class="img">
                <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                     alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>"></div>
            </div>
            <div class="col">
              <div class="title h2">After</div>
              <?php $image_repeater = get_sub_field ('comparison_after'); ?>
              <div class="img">
                <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                     loading="lazy" alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
              </div>
            </div>
          </div>
          <?php
          $link = get_sub_field ('comparison_button');
          if ($link):
            $link_url = $link[ 'url' ];
            $link_title = $link[ 'title' ];
            $link_target = $link[ 'target' ] ? $link[ 'target' ] : '_self';
            ?>
            <div class="section-btn">
              <a href="<?php echo esc_url ($link_url); ?>" class="btn btn-8"
                 target="<?php echo esc_attr ($link_target); ?>"><?php echo esc_html ($link_title); ?></a>
            </div>
          <?php endif; ?>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'testimonial'): ?>
      <!--TESTIMONIAL SINGLE-->
      <section class="s-testimonial-single ms-section">
        <div class="cn">
          <div class="s-testimonial-single__inner">
            <div class="section-heading">
              <h2 class="title h1"><?php echo get_sub_field ('testimonial_section_title'); ?></h2>
            </div>
            <a href="<?php echo get_sub_field ('testimonial_link'); ?>" class="t-item" target="_blank" rel="noopener">
              <?php $image_repeater = get_sub_field ('testimonial_image'); ?>
              <div class="img-wrapper">
                <div class="img">
                  <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                       alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                </div>
                <div class="img--google">
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 642.84 320">
                    <g id="Google_Color" data-name="Google Color">
                      <path d="M201.58,162.32A119.24,119.24,0,0,0,200,142.84H103v38.7H158.5a47.8,47.8,0,0,1-20.59,30.72V238H171C190.42,220.07,201.58,193.64,201.58,162.32Z"
                            style="fill:#4285f4"></path>
                      <path d="M103,263c27.8,0,51.06-9.27,68.05-25l-33.12-25.75c-9.27,6.18-21,10-34.93,10-26.86,0-49.6-18.11-57.76-42.57H11.07v26.52A102.83,102.83,0,0,0,103,263Z"
                            style="fill:#34a853"></path>
                      <path d="M45.22,179.65A59.87,59.87,0,0,1,42,160a62.33,62.33,0,0,1,3.26-19.65V113.83H11.07a101.82,101.82,0,0,0,0,92.34Z"
                            style="fill:#fbbc05"></path>
                      <path d="M103,97.78c15.19,0,28.75,5.24,39.47,15.45L171.8,83.88C154,67.23,130.78,57,103,57a102.83,102.83,0,0,0-91.91,56.81l34.15,26.52C53.38,115.89,76.12,97.78,103,97.78Z"
                            style="fill:#ea4335"></path>
                      <path d="M270,237h-9.45V163.44h25.05a22.9,22.9,0,0,1,16.27,6.32,21.08,21.08,0,0,1,1.75,29.05A22.07,22.07,0,0,1,291,206.35l-.2.31,20.63,29.88V237H300.24l-19.81-29.77H270Zm0-64.47v25.87h15.19a13.77,13.77,0,0,0,9.76-3.75,12.25,12.25,0,0,0,4-9.29,13,13,0,0,0-13.14-12.83Zm69.81,66.11a24.06,24.06,0,0,1-18.28-7.6q-7.19-7.59-7.18-19.19t7-19.15A23.1,23.1,0,0,1,339.15,185q11.19,0,17.81,7.24t6.62,20.27l-.1,1H324a16.36,16.36,0,0,0,4.93,11.91A15.75,15.75,0,0,0,340.18,230q9,0,14.17-9l8.41,4.11a25.11,25.11,0,0,1-9.39,10A26,26,0,0,1,339.77,238.59Zm-15.09-32.85h28.84a12.52,12.52,0,0,0-4.26-8.68q-3.84-3.44-10.31-3.44a13.69,13.69,0,0,0-9.19,3.29A15.65,15.65,0,0,0,324.68,205.74ZM395.62,237h-9.45l-20.33-50.31h10.27l14.78,39h.21l15-39h10.06Zm38.9-67.66a6.66,6.66,0,1,1-1.95-4.72A6.45,6.45,0,0,1,434.52,169.29Zm-1.95,17.35V237h-9.44V186.64Zm34.4,52a24,24,0,0,1-18.28-7.6q-7.19-7.59-7.18-19.19t7-19.15A23.08,23.08,0,0,1,466.35,185q11.19,0,17.81,7.24t6.62,20.27l-.1,1H451.16a16.35,16.35,0,0,0,4.92,11.91,15.79,15.79,0,0,0,11.3,4.52q9,0,14.16-9L490,225a25.18,25.18,0,0,1-9.39,10A26,26,0,0,1,467,238.59Zm-15.1-32.85h28.85a12.52,12.52,0,0,0-4.26-8.68q-3.84-3.44-10.32-3.44a13.66,13.66,0,0,0-9.18,3.29A15.72,15.72,0,0,0,451.87,205.74Zm117.76-19.1L553.41,237h-9.65l-12.53-38.6L518.81,237h-9.55L493,186.64h9.86l11.19,38h.1l12.42-38h9.76l12.42,38h.1l11.09-38ZM614.29,223q0,6.57-5.75,11.08t-14.48,4.52a23,23,0,0,1-13.34-4,21.84,21.84,0,0,1-8.22-10.42l8.42-3.6a15.61,15.61,0,0,0,5.39,7,13.13,13.13,0,0,0,7.75,2.51,13.69,13.69,0,0,0,7.55-1.95q3-2,3-4.62c0-3.21-2.47-5.58-7.39-7.08l-8.63-2.16q-14.68-3.69-14.68-14.17a13.06,13.06,0,0,1,5.6-11q5.58-4.16,14.32-4.16a23.29,23.29,0,0,1,12.06,3.18,17.4,17.4,0,0,1,7.55,8.52l-8.42,3.49a10.59,10.59,0,0,0-4.67-5,14.64,14.64,0,0,0-7.24-1.8,12.05,12.05,0,0,0-6.62,1.85c-1.95,1.23-2.93,2.74-2.93,4.51q0,4.32,8.11,6.16l7.6,1.95Q614.29,211.6,614.29,223Z"
                            style="fill:#6f7073"></path>
                      <path d="M280.35,63.52l8.42,25.92H316l-22,16,8.42,25.92-22-16-22.06,16,8.43-25.92-22.06-16h27.26Zm73.27,25.92H326.36l22.06,16L340,131.39l22.06-16,22.05,16-8.42-25.92,22.05-16H370.47l-8.42-25.92Zm81.71,0H408.07l22.05,16-8.42,25.92,22.05-16,22.06,16-8.43-25.92,22.06-16H452.18l-8.43-25.92Zm81.7,0H489.77l22.05,16-8.42,25.92,22.05-16,22.06,16-8.42-25.92,22-16H533.88l-8.43-25.92Zm81.7,0H571.47l22.06,16-8.43,25.92,22.06-16,22.05,16-8.42-25.92,22.05-16H615.58l-8.42-25.92Z"
                            style="fill:#fbbc05"></path>
                    </g>
                  </svg>
                  <!--                  <img src="-->
                  <?php //echo get_template_directory_uri(); ?><!--/assets/images/google-review.png" loading="lazy" alt="-->
                  <?php //echo esc_attr ($image_repeater[ 'alt' ]); ?><!--">-->
                </div>
              </div>
              <div class="name"><?php echo get_sub_field ('testimonial_name'); ?></div>
              <div class="title"><?php echo get_sub_field ('testimonial_title'); ?></div>
              <div class="text"><?php echo get_sub_field ('testimonial_text'); ?></div>
            </a>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'banner'): ?>

      <!--BANNER-->
      <section class="s-banner-2 ms-section">
        <div class="section-bg"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-06.jpg"
                                     loading="lazy" alt=""></div>
        <div class="cn">
          <div class="s-banner-2__inner">
            <div class="s-banner-2__left">
              <div class="decorated-title decorated-title--column-left">
                <div class="small-title small-title--white">EXPERIENCED</div>
                <div class="line-decor line-decor--white"></div>
              </div>
              <h2 class="title h1">Refurbishing Brake Calipers for Cars Worldwide</h2>
            </div>
            <div class="s-banner-2__right">
              <div class="form">
                <h3 class="title h2"><?php echo get_sub_field ('banner_title'); ?></h3>
                <div class="subtitle"><?php echo get_sub_field ('banner_description'); ?></div>
                <?php echo do_shortcode ('[contact-form-7 id="79c53f2" title="Email"]') ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'related'): ?>
      <!--ARTICLES LIST-->
      <section class="s-articles-list ms-section">
        <div class="section-bg"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-07.jpg"
                                     loading="lazy" alt=""></div>
        <div class="cn">
          <div class="section-heading">
            <h2 class="title h1"><?php echo get_sub_field ('related_title'); ?></h2>
            <div class="subtitle"><?php echo get_sub_field ('related_subtitle'); ?></div>
          </div>

          <div class="swiper articles-slider">
            <div class="swiper-arrows">
              <div class="swiper-button-prev btn btn-4">
                <span class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                    <path d="M7.37598 10.2383L2.98681 5.83951L7.37598 1.44076L6.02473 0.0895081L0.274727 5.83951L6.02473 11.5895L7.37598 10.2383Z"/>
                  </svg>
                </span>
                <span>Previous</span>
              </div>
              <div class="swiper-button-next btn btn-4">
                <span>Next</span>
                <span class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                    <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                  </svg>
                </span>
              </div>
            </div>
            <div class="swiper-wrapper">
              <?php
              $post_ID = $post->ID;
              $make_tax = get_sub_field ('related_posts');
              $portfolio_posts = get_sub_field ('posts');
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
                  'post__not_in' => $post_ID,
              ));

              if ($query->have_posts ()) :
                while ($query->have_posts ()) :
                  $query->the_post (); ?>

                  <div class="swiper-slide">
                    <div class="article-card">
                      <div class="article-card__img">
                        <?php $image_repeater = get_field ('overview_image'); ?>
                        <?php if ($image_repeater) { ?>
                          <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                               alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                        <?php } ?>
                      </div>
                      <div class="article-card__content">
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
                        <h3 class="title"><?php echo get_the_title (); ?></h3>
                        <div class="desc"><?php echo get_field ('preview_description'); ?></div>
                        <a href="<?php the_permalink (); ?>" class="btn btn-3">
                          <span>Read more</span>
                          <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12"
                                 fill="none">
                              <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                            </svg>
                          </span>
                        </a>
                      </div>
                    </div>
                  </div>

                <?php endwhile;
              endif;
              wp_reset_postdata (); ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </section>
    <?php elseif (get_row_layout () == 'products'): ?>
      <?php
      $post_ID = $post->ID;
      $make_tax = get_sub_field ('products_category');
      $portfolio_posts = get_sub_field ('products');
      // Push posts IDs to new array
      $identifiers = array();
      if (( $make_tax ) || ( $portfolio_posts )) {
        if ($make_tax) {
          $args_1 = get_posts (array(
              'post_type' => 'product',
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
              'post_type' => 'product',
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
            'post_type' => 'product',
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
          'post_type' => 'product',
          'post_status' => 'publish',
          'post_count' => -1,
          'post__in' => array_unique ($identifiers),
          'post__not_in' => $post_ID,
      ));

      if ($query->have_posts ()) :?>
        <!--PRODUCTS-->
        <section class="s-products ms-section">
          <div class="cn">
            <div class="section-heading section-heading--simple">
              <h2 class="title h1"><?php echo get_sub_field ('products_title'); ?></h2>
              <div class="subtitle"><?php echo get_sub_field ('products_subtitle'); ?></div>
            </div>
            <div class="products-list">
              <?php while ($query->have_posts ()) :
                $query->the_post (); ?>
                <div class="product-card">
                  <div class="product-card__img">
                    <a href="<?php echo esc_url ($product->get_permalink ()); ?>">
                      <?php if ($product->get_image_id ()) : ?>
                        <img src="<?php echo wp_get_attachment_url ($product->get_image_id ()); ?>" loading="lazy"
                             alt="<?php echo esc_attr ($product->get_name ()); ?>">
                      <?php else : ?>
                        <!-- Fallback static image -->
                        <img src="<?php echo esc_url (wc_placeholder_img_src ()); ?>" loading="lazy"
                             alt="No image available">
                      <?php endif; ?>
                    </a>
                  </div>
                  <div class="product-card__content">
                    <h3 class="title"><?php echo esc_html ($product->get_name ()); ?></h3>
                    <div class="subtitle">
                      <?php
                      // Check if product is variable
                      if ($product->is_type ('variable')) {
                        // Get minimum and maximum prices for the variable product
                        echo $product->get_price_html (); // WooCommerce function to display variable product price range
                      } else {
                        // Display regular price for simple products
                        echo wc_price ($product->get_price ());
                      }
                      ?>
                    </div>
                    <div class="btn-group">
                      <?php
                      // Generate a Buy Now button with WooCommerce's "add_to_cart_url" function
                      $add_to_cart_url = esc_url ($product->add_to_cart_url ());
                      ?>
                      <a href="<?php echo $add_to_cart_url; ?>" class="btn btn-2"
                         data-product_id="<?php echo esc_attr ($product->get_id ()); ?>">
                        Buy Now </a>
                    </div>
                  </div>
                </div>
              <?php endwhile; ?>
            </div>
            <div class="section-btn"><a href="#" class="btn btn-1">Show more</a></div>
          </div>
        </section>
      <?php endif;
      wp_reset_postdata (); ?>

    <?php elseif (get_row_layout () == 'services'): ?>
      <!--SERVICES-->
      <section class="s-services-main ms-section">
        <div class="s-services-main__head">
          <div class="section-bg">
            <img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-02.png"
                 loading="lazy" alt="">
          </div>
          <div class="cn">
            <div class="section-heading">
              <h2 class="title h1"><?php echo get_sub_field ('title'); ?></h2>
              <div class="subtitle"><?php echo get_sub_field ('subtitle'); ?></div>
              <div class="decorated-title decorated-title--row-left">
                <div class="small-title small-title--white"><?php echo get_sub_field ('small_title'); ?></div>
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
                    <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>"
                         loading="lazy" alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
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
    <?php endif;
    // End loop.
  endwhile;
// No value.
else :
  // Do something...
endif; ?>

<?php
get_footer ();
