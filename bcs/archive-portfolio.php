<?php
/**
 * The template for displaying archive pages
 *
 */

get_header ();
require_once get_template_directory() . '/includes/partials/pagination.php';
?>

  <!--VEHICLES-->
  <section class="s-vehicles-simple ms-section">
    <div class="section-bg"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-05.jpg" loading="lazy" alt=""></div>
    <div class="cn">
      <div class="section-heading">
        <h1 class="title h1">Find Your Vehicle</h1>
        <div class="subtitle">Select your vehicle make, model, and trim to get personalized recommendations.</div>
      </div>
      <?php echo render_vehicle_search_form (); ?>
    </div>
  </section>

  <!--SPLIT-->
  <section class="s-split s-portfolio ms-section">
    <div class="cn">
      <div class="section-heading">
        <div class="decorated-title decorated-title--column-center">
          <div class="small-title small-title--gray">DISCOVER</div>
          <div class="line-decor line-decor--red"></div>
        </div>
        <h2 class="title h1">Portfolio</h2>
        <div class="subtitle">Explore our latest projects and see how we can help you.</div>
      </div>
      <div class="portfolio-filter">
        <!--        <div class="selected_vehicle">-->
        <!--            <div class="selected_vehicle__title">Selected Vehicle:</div>-->
        <!--            <div class="selected_vehicle__info">-->
        <!--                <div class="selected_vehicle__make">Make: <span class="selected_vehicle__make-value">All</span></div>-->
        <!--                <div class="selected_vehicle__model">Model: <span class="selected_vehicle__model-value">All</span></div>-->
        <!--                <div class="selected_vehicle__trim">Trim: <span class="selected_vehicle__trim-value">All</span></div>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="portfolio-cat-filter">
          <div class="custom-select">
            <select name="portfolio-cat" id="" class="portfolio-cat__select">
              <option data-category="" value="portfolio_category">Services Type</option>
              <option data-category="" value="portfolio_category">Services Type</option>
              <?php
              // Get the parent terms of the 'make' taxonomy
              $terms = get_terms ('portfolio_category');
              // Loop through parent terms and set active class if it matches current or parent
              foreach ($terms as $term) { ?>
                <option data-category="<?php echo esc_attr ($term->term_id); ?>" value="<?php echo esc_attr ($term->slug); ?>"><?php echo esc_html ($term->name); ?></option>
              <?php } ?>
            </select>
          </div>
<!--          <div class="custom-select">-->
<!--            <select name="product-used" id="" class="portfolio-cat__select">-->
<!--              <option data-used="" value="product_used">Products Used</option>-->
<!--              <option data-used="" value="product_used">Products Used</option>-->
<!--              --><?php
//              // Get the parent terms of the 'product_used' taxonomy
//              $terms = get_terms ('product_used');
//              // Loop through parent terms and set active class if it matches current or parent
//              foreach ($terms as $term) { ?>
<!--                <option data-used="--><?php //echo esc_attr ($term->term_id); ?><!--" value="--><?php //echo esc_attr ($term->slug); ?><!--">--><?php //echo esc_html ($term->name); ?><!--</option>-->
<!--              --><?php //} ?>
<!--            </select>-->
<!--          </div>-->
          <div class="custom-select">
            <select name="city-state" id="" class="portfolio-cat__select">
              <option data-city-state="" value="city_state">City & State</option>
              <option data-city-state="" value="city_state">City & State</option>
              <?php
              // Get the parent terms of the 'state' taxonomy
              $terms = get_terms ('location');
              // Loop through parent terms and set active class if it matches current or parent
              foreach ($terms as $term) { ?>
                <option data-city-state="<?php echo esc_attr ($term->term_id); ?>"
                        value="<?php echo esc_attr ($term->slug); ?>"><?php echo esc_html ($term->name); ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <div class="portfolio-filter-secondary">
          <div class="sort-select custom-select">
            <select placeholder="Sort By">
              <option value="newest">Newest</option>
              <option value="newest">Newest</option>
              <option value="oldest">Oldest</option>
              <option value="increase">By name A-Z</option>
              <option value="reduction">By name Z-A</option>
            </select>
          </div>
          <button class="btn btn-1 js-reset-filtering">Reset All</button>
        </div>
      </div>

      <div class="portfolio__list">
        <?php
        // New query
        $query = new WP_Query(array(
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'post_count' => get_option('posts_per_page'),
//            'posts_per_page' => get_option('posts_per_page'),
        ));
        if ($query->have_posts ()) :?>
          <?php while ($query->have_posts ()) :
            $query->the_post (); ?>
            <div class="portfolio__item">
              <a href="<?php the_permalink (); ?>" class="portfolio__image">
                <?php $image_repeater = get_field ('overview_image'); ?>
                <?php if ($image_repeater) { ?>
                  <img src="<?php echo $image_repeater[ 'url' ]; ?>" loading="lazy" alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                <?php } else { ?>
                  <img src="<?php echo get_template_directory_uri (); ?>/assets/images/Portfolio_Placeholder.webp" loading="lazy" alt="Portfolio Placeholder">
                <?php } ?>
              </a>
              <div class="portfolio__content">
                <div class="portfolio__tags">
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
                <div class="model"><?php echo get_the_title (); ?></div>
                <div class="info"><?php echo get_field ('preview_description'); ?></div>
                <!--                <a href="--><?php //the_permalink ();
                ?><!--" class="btn btn-2">View</a>-->
              </div>
              <div class="btn-wrapper">
                <a href="<?php the_permalink (); ?>" class="btn btn-2">View</a>
              </div>
            </div>
          <?php endwhile; ?>

        <?php endif; ?>

        <!--   Pagination   -->
        <?php render_pagination($query, 1); ?>

        <?php wp_reset_postdata (); ?>
      </div>
    </div>
  </section>

  <!--BANNER-->
  <section class="s-banner-1 ms-section">
    <div class="s-banner-1__img">
      <div class="img"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
    </div>
    <div class="cn">
      <div class="s-banner-1__content">
        <div class="section-heading">
          <h2 class="title h1">Engineering & ReManufacture</h2>
        </div>
        <ul class="list">
          <li>Brake Caliper Refurbishment</li>
          <li>Engineering and Coatings</li>
        </ul>
        <a href="#" class="btn btn-3">
          <span>Submit</span>
          <span class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
              <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
            </svg>
          </span>
        </a>
      </div>
    </div>
  </section>

<?php echo get_template_part ('includes/content', 'reviews'); ?>

<?php
get_footer ();
