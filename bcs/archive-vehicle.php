<?php get_header ();

$options = get_cached_acf_options();
?>


<section class="s-vehicles ms-section">
  <div class="s-vehicles__head">
    <div class="cn">
      <div class="section-heading">
        <h1 class="title h1">Find Your Vehicle</h1>
        <div class="subtitle">Select your vehicle make, model, and trim to get personalized recommendations.</div>
      </div>
      <?php echo render_vehicle_search_form (); ?>
    </div>
  </div>

  <div class="cn">
    <div class="s-vehicles__list">
      <?php

      $args = array(
          'post_type' => 'vehicle',
      );

      // The Query.
      $the_query = new WP_Query($args);

      // The Loop.
      if ($the_query->have_posts ()) {
        // Pre-fetch all post IDs
        $post_ids = wp_list_pluck ($the_query->posts, 'ID');

        // Pre-load ACF fields for all posts in one query
        $all_fields = [];
        foreach ($post_ids as $post_id) {
          $all_fields[ $post_id ] = get_fields ($post_id);
        }

        // Pre-load all taxonomy terms
        $all_terms = [];
        $terms_data = wp_get_object_terms ($post_ids, 'make', ['orderby' => 'term_id', 'order' => 'ASC']);
        foreach ($terms_data as $term) {
          if (!isset($all_terms[ $term->object_id ])) {
            $all_terms[ $term->object_id ] = [];
          }
          $all_terms[ $term->object_id ][] = $term;
        }

        // Loop through posts
        while ($the_query->have_posts ()) {
          $the_query->the_post ();
          $post_id = get_the_ID ();
          $post_fields = $all_fields[ $post_id ] ?? [];
          $post_terms = $all_terms[ $post_id ] ?? [];

          // Now use the pre-loaded data
          ?>
          <div class="vehicle-card">
            <a href="<?php the_permalink (); ?>" class="img">
              <?php if (!empty($post_fields[ 'preview_image' ])): ?>

                <img src="<?php echo esc_url ($post_fields[ 'preview_image' ][ 'url' ]); ?>"
                     loading="lazy"
                     alt="<?php echo esc_attr ($post_fields[ 'preview_image' ][ 'alt' ]); ?>">

              <?php endif; ?>
            </a>
            <?php if (!empty($post_terms)):
              $project = array_map (function ($term) {
                return $term->name;
              }, $post_terms);
              ?>
              <div class="brand"><?php echo $project[ 0 ] ?? ''; ?></div>
              <div class="model"><?php echo $project[ 1 ] ?? ''; ?></div>
            <?php endif; ?>

            <div class="info"><?php echo get_the_title (); ?></div>
            <a href="<?php the_permalink (); ?>" class="btn btn-2">View</a>
          </div>
        <?php }
      }
      wp_reset_postdata ();


      ?>
    </div>
  </div>
</section>

<?php
$args = array(
    'post_type' => 'portfolio',    // Custom post type
    'posts_per_page' => 3,              // Number of portfolio posts to display
    'meta_key' => 'views', // Meta key used by Post Views Counter plugin
    'orderby' => array(
        'meta_value_num' => 'DESC',     // Order by view count first (if it exists)
        'date' => 'DESC',     // Then by date
    ),
    'meta_query' => array(          // Only include posts that have views
        'relation' => 'OR',
        array(
            'key' => '_post_views_count',
            'compare' => 'EXISTS'
        ),
        array(
            'key' => '_post_views_count',
            'compare' => 'NOT EXISTS'   // Also include posts with no views to show new posts
        )
    )
);

$query = new WP_Query($args);

if ($query->have_posts ()) : ?>
  <!-- SPECIALIST REVIEWS -->
  <section class="s-specialists-reviews ms-section">
    <div class="section-bg">
      <img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-01.png" loading="lazy" alt="">
    </div>
    <div class="cn cn--big">
      <div class="section-heading">
        <div class="decorated-title decorated-title--column-center">
          <div class="small-title small-title--white">DISCOVER</div>
          <div class="line-decor line-decor--red"></div>
        </div>
        <h2 class="title h1"><?php echo $options['portfolio_title']; ?></h2>
        <div class="subtitle"><?php echo $options['portfolio_subtitle']; ?></div>
      </div>

      <div class="s-specialists-reviews__list">
        <?php while ($query->have_posts ()) : $query->the_post (); ?>
          <div class="sr-item">
            <div class="sr-item__img">
              <?php $image_id = get_field ('overview_image', false); // false returns just the ID
              if ($image_id): ?>
                <?php echo wp_get_attachment_image ($image_id, 'medium', false, ['loading' => 'lazy']); ?>
              <?php endif; ?>
            </div>
            <div class="sr-item__content">
              <h3 class="title h2"><?php the_title (); ?></h3>
              <div class="tags">
                <?php
                $term_list = wp_get_post_terms ($post->ID, 'portfolio_category', ['fields' => 'all']);
                // Виводимо назву первинної категорії
                foreach ($term_list as $term_primary) {
                  $primary_category = get_post_meta ($post->ID, '_yoast_wpseo_primary_portfolio_category', true);
                  if ($primary_category == $term_primary->term_id) {
                    echo '<div class="tag">' . esc_html ($term_primary->name) . '</div>';
                    break; // Припиняємо цикл після знаходження первинної категорії
                  }
                } ?>
              </div>
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
        <?php endwhile; ?>
      </div>
    </div>
  </section>
<?php endif;
wp_reset_postdata (); ?>


<!--SERVICES-->
<section class="s-services-main ms-section">
  <div class="s-services-main__head">
    <div class="section-bg">
      <img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-02.png" loading="lazy" alt="">
    </div>
    <div class="cn">
      <div class="section-heading">
        <h2 class="title h1"><?php echo $options['services_title']; ?></h2>
        <div class="subtitle"><?php echo $options['services_subtitle']; ?></div>
        <div class="decorated-title decorated-title--row-left">
          <div class="small-title small-title--white">Our services</div>
          <div class="line-decor line-decor--white"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="cn">
    <div class="services-list">
      <?php $args = array(
          'post_type' => 'page',         // Query for pages
          'post_parent' => 24464,          // Only get pages where the parent is the page with ID 24464
          'posts_per_page' => -1,             // Retrieve all child pages (or specify a number)
      );
      $query = new WP_Query ($args); ?>
      <?php
      // The Query.
      $the_query = new WP_Query($args);

      // The Loop.
      if ($the_query->have_posts ()) {

        while ($the_query->have_posts ()) {
          $the_query->the_post (); ?>
          <div class="service-item">
            <?php
            $image_id = get_field ('services_preview_image', false); // false returns just the ID
            if ($image_id): ?>
              <div class="img">
                <?php echo wp_get_attachment_image ($image_id, 'medium', false, ['loading' => 'lazy']); ?>
              </div>
            <?php endif; ?>
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
        <?php }
      }
      wp_reset_postdata ();
      ?>
    </div>
  </div>
</section>

<!--BANNER-->
<section class="s-banner-1 ms-section">
  <div class="s-banner-1__img">
    <div class="img">
      <img src="<?php echo get_template_directory_uri (); ?>/assets/images/img-02.jpg" loading="lazy" alt="">
    </div>
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

<!--PRODUCTS-->
<section class="s-products-main ms-section">
  <div class="cn">
    <div class="section-heading">
      <div class="decorated-title decorated-title--column-center">
        <div class="small-title small-title--gray">DISCOVER</div>
        <div class="line-decor line-decor--red"></div>
      </div>
      <h2 class="title h1"><?php echo $options['product_title']; ?></h2>
      <div class="subtitle"><?php echo $options['products_subtitle']; ?></div>
    </div>
    <div class="products-list">
      <?php $args = array(
          'post_type' => 'product',         // Specify the post type as 'product' (for WooCommerce)
          'posts_per_page' => 6,                 // Number of products to display
          'tax_query' => array(             // Query for a specific product category
              array(
                  'taxonomy' => 'product_cat',   // WooCommerce product category taxonomy
                  'field' => 'term_id',       // Use 'term_id' to target by category ID
                  'terms' => 153311,          // Category ID (in this case, 153311)
              ),
          ),
      );
      $query = new WP_Query ($args); ?>
      <?php
      // The Query.
      $the_query = new WP_Query($args);

      // The Loop.
      if ($the_query->have_posts ()) {

        while ($the_query->have_posts ()) {
          $the_query->the_post (); ?>
          <div class="product-card">
            <div class="product-card__img">
              <a href="<?php echo esc_url ($product->get_permalink ()); ?>">
                <?php if ($product->get_image_id ()) : ?>
                  <img src="<?php echo wp_get_attachment_url ($product->get_image_id ()); ?>" loading="lazy"
                       alt="<?php echo esc_attr ($product->get_name ()); ?>">
                <?php else : ?>
                  <!-- Fallback static image -->
                  <img src="<?php echo esc_url (wc_placeholder_img_src ()); ?>" loading="lazy" alt="No image available">
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
        <?php }
      }
      wp_reset_postdata (); ?>

    </div>
    <div class="section-btn"><a href="/staging/products/brake-caliper-paint-kits/" class="btn btn-1">View all</a></div>
  </div>
</section>

<?php echo get_template_part ('includes/content', 'reviews'); ?>

<!--BANNER-->
<section class="s-banner-2 ms-section">
  <div class="section-bg"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-03.png" loading="lazy"
                               alt=""></div>
  <div class="cn">
    <div class="s-banner-2__inner">
      <div class="s-banner-2__left">
        <div class="decorated-title decorated-title--column-left">
          <div class="small-title small-title--white"><?php echo get_field ('cto_category_small_title', 'option'); ?></div>
          <div class="line-decor line-decor--white"></div>
        </div>
        <h2 class="title h1"><?php echo get_field ('cto_category_title', 'option'); ?></h2>
      </div>
      <div class="s-banner-2__right">
        <div class="numbers">
          <?php if (have_rows ('cto_category_items', 'option')): ?>
            <?php while (have_rows ('cto_category_items', 'option')) : the_row (); ?>
              <?php $image_repeater = get_sub_field ('icon'); ?>
              <div class="item">
                <div class="title">
                  <div class="icon">
                    <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy"
                         alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
                  </div>
                  <div><?php echo get_sub_field ('title'); ?></div>
                </div>
                <div class="desc"><?php echo get_sub_field ('description'); ?></div>
              </div>
            <?php endwhile; ?>
          <?php endif; ?>
        </div>
        <div class="text"><?php echo get_field ('cto_category_text', 'option'); ?></div>
      </div>
    </div>
  </div>
</section>

<?php get_footer (); ?>
