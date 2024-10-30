<?php
/*
Template Name: Thank You

*/
get_header ();
?>

<section class="s-thank_you section">
  <div class="cn">
    <header class="section-heading section-heading--gaps-lg">
      <h1 class="title h1"><?php the_title(); ?></h1>

      <div class="icon"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/check.png" alt="Thank you for your request!"></div>
      <div>Thank you for your request!</div>
      <div>We will contact you as soon as possible</div>
    </header>
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
      <img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-01.png" loading="lazy" alt="SPECIALIST REVIEWS background"></div>
    <div class="cn cn--big">
      <div class="section-heading">
        <div class="decorated-title decorated-title--column-center">
          <div class="small-title small-title--white">DISCOVER</div>
          <div class="line-decor line-decor--red"></div>
        </div>
        <h2 class="title h1"><?php echo get_field ('portfolio_title', 'option'); ?></h2>
        <div class="subtitle"><?php echo get_field ('portfolio_subtitle', 'option'); ?></div>
      </div>

      <div class="s-specialists-reviews__list">
        <?php while ($query->have_posts ()) : $query->the_post (); ?>
          <div class="sr-item">
            <div class="sr-item__img">
              <?php $image_repeater = get_field ('overview_image'); ?>
              <?php if ($image_repeater) { ?>
                <img src="<?php echo esc_url ($image_repeater[ 'url' ]); ?>" loading="lazy" alt="<?php echo esc_attr ($image_repeater[ 'alt' ]); ?>">
              <?php } ?>
            </div>
            <div class="sr-item__content">
              <h3 class="title h2"><?php the_title (); ?></h3>
              <div class="tags">
                <?php
                $terms = wp_get_object_terms ($post->ID, 'portfolio_category', array('orderby' => 'term_id', 'order' => 'ASC'));
                if (!empty($terms)) :
                  foreach ($terms as $term) { ?>
                    <div class="tag"><?php echo esc_html ($term->name); ?></div>
                  <?php }
                endif;
                ?>
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
