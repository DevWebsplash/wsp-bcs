<?php

/*
Template Name: ACF Template
Template Post Type: Portfolio
*/

get_header();
?>
    <!--HERO variant 2-->
    <section class="s-hero s-hero--variant-2 ms-section">
        <div class="cn cn--big">
            <div class="inner-content">
                <div class="inner-content__img">
	                <?php $image_repeater = get_field( 'overview_image' ); ?>
                    <img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                         loading="lazy"
                         alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>">
                </div>
                <div class="empty"></div>
                <div class="inner-content__text">
                    <div class="section-heading">
                        <h1 class="title h1"><?php echo get_the_title();?></h1>
                    </div>
                    <div class="info-1">
                        <div class="item">
                            <div class="icon"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/icon-07.svg" loading="lazy" alt=""></div>
                            <div>
                                <div class="title">Project Status</div>
                                <div><?php echo get_field( 'overview_project_status' ); ?></div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="icon"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/icon-08.svg" loading="lazy" alt=""></div>
                            <div>
                                <div class="title">Location</div>
                                <div><?php echo get_field( 'overview_location' ); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="info-2">
                        <div class="block-title">Services offered:</div>
	                    <?php if ( have_rows( 'services_offered' ) ): ?>
		                    <?php while ( have_rows( 'services_offered' ) ) : the_row(); ?>
                                <div class="item">
	                                <?php $image_repeater = get_sub_field( 'icon' ); ?>
                                    <div class="icon"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                                           loading="lazy"
                                                           alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></div>
                                    <div><?php echo get_sub_field( 'text' ); ?></div>
                                </div>
		                    <?php endwhile; ?>
	                    <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
// Check value exists.
if ( have_rows( 'flixble_content_portfolio' ) ):
	$i = 0;
	// Loop through rows.
	while ( have_rows( 'flixble_content_portfolio' ) ) : the_row();
		$i ++;
		// Case: Paragraph layout.
		if ( get_row_layout() == 'video' ):?>
            <!--VIDEO variant 4-->
            <section class="s-video s-video--variant-4 ms-section">
                <div class="cn">
                    <div class="inner-content">
                        <div class="inner-content__text">
                            <div class="section-heading">
                                <h2 class="title h1"><?php echo get_sub_field( 'video_title' ); ?></h2>
                            </div>
                            <div class="text"><?php echo get_sub_field( 'video_description' ); ?></div>
                        </div>
                        <div class="inner-content__media">
                            <div class="video">
                                <iframe width="560" height="315"
                                        src="https://www.youtube.com/embed/<?php echo get_sub_field( 'video' ); ?>"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
				<?php elseif ( get_row_layout() == 'steps' ): ?>
            <!--STEPS-->
            <section class="s-steps ms-section">
                <div class="cn">
                    <div class="section-heading">
                        <h2 class="title h1"><?php echo get_sub_field( 'steps_title' ); ?></h2>
                    </div>
                    <div class="s-steps__list">
	                    <?php $i=0; if ( have_rows( 'steps_repeater' ) ): ?>
		                    <?php while ( have_rows( 'steps_repeater' ) ) : the_row(); $i++;?>
                                <div class="s-steps__box">
                                    <div class="block-title">
                                        <h3 class="title h2">Step <?php echo $i;?></h3>
                                        <div class="date"><?php echo get_sub_field( 'data' ); ?></div>
                                    </div>
	                                <?php if ( have_rows( 'images' ) ): ?>
                                      <div class="images">
				                                <?php while ( have_rows( 'images' ) ) : the_row(); ?>
					                                <?php $image_repeater = get_sub_field( 'image' ); ?>
                                            <div class="img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                                                  loading="lazy"
                                                                  alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>">
                                            </div>
				                                <?php endwhile; ?>

                                      </div>
	                                <?php endif; ?>
                                    <div class="overflow-text-cn">
                                        <div class="overflow-text">
                                            <div class="text"><?php echo get_sub_field( 'text' ); ?></div>
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



		<?php elseif ( get_row_layout() == 'overview' ): ?>
            <!--OVERVIEW variant 1-->
            <section class="s-overview s-overview--variant-1 ms-section">
                <div class="cn">
                    <div class="section-heading">
                        <h2 class="title h1"><?php echo get_sub_field( 'overview_title' ); ?></h2>
                    </div>
                    <div class="inner-content">
                        <div class="inner-content__text">
                            <div class="text"><?php echo get_sub_field( 'overview_content' ); ?></div>
                        </div>
                    </div>
                </div>
            </section>
        <?php elseif ( get_row_layout() == 'comparison' ): ?>
            <!--COMPARISON-->
            <section class="s-comparison ms-section">
                <div class="cn">
                    <div class="inner-content">
                        <div class="col">
                            <div class="title h2">Before</div>
	                        <?php $image_repeater = get_sub_field( 'comparison_before' ); ?>
                            <div class="img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                                  loading="lazy"
                                                  alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></div>
                        </div>
                        <div class="col">
                            <div class="title h2">After</div>
	                        <?php $image_repeater = get_sub_field( 'comparison_after' ); ?>
                            <div class="img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                                  loading="lazy"
                                                  alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></div>
                        </div>
                    </div>	<?php
	                $link = get_sub_field( 'comparison_button' );
	                if ( $link ):
		                $link_url    = $link['url'];
		                $link_title  = $link['title'];
		                $link_target = $link['target'] ? $link['target'] : '_self';
		                ?>
                        <div class="section-btn">
                            <a href="<?php echo esc_url( $link_url ); ?>" class="btn btn-8"   target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                        </div>
	                <?php endif; ?>
                </div>
            </section>
				<?php elseif ( get_row_layout() == 'testimonial' ): ?>
            <!--TESTIMONIAL SINGLE-->
            <section class="s-testimonial-single ms-section">
                <div class="cn">
                    <div class="s-testimonial-single__inner">
                        <div class="section-heading">
                            <h2 class="title h1"><?php echo get_sub_field( 'testimonial_section_title' ); ?></h2>
                        </div>
                        <div class="t-item">
	                        <?php $image_repeater = get_sub_field( 'testimonial_image' ); ?>
                            <div class="img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                                  loading="lazy"
                                                  alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></div>
                            <div class="name"><?php echo get_sub_field( 'testimonial_name' ); ?></div>
                            <div class="title"><?php echo get_sub_field( 'testimonial_title' ); ?></div>
                            <div class="text"><?php echo get_sub_field( 'testimonial_text' ); ?></div>
                        </div>
                    </div>
                </div>
            </section>
        <?php elseif ( get_row_layout() == 'banner' ): ?>

            <!--BANNER-->
            <section class="s-banner-2 ms-section">
                <div class="section-bg"><img src="<?php echo get_template_directory_uri();?>/assets/images/bg-06.jpg" loading="lazy" alt=""></div>
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
                                <h3 class="title h2"><?php echo get_sub_field( 'banner_title' ); ?></h3>
                                <div class="subtitle"><?php echo get_sub_field( 'banner_description' ); ?></div>
                                <form>
                                    <div class="form-group">
                                        <input type="email" class="input" placeholder="Email">
                                    </div>
                                    <div class="form-group btn-group">
                                        <button type="submit" class="btn btn-8">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php elseif ( get_row_layout() == 'related' ): ?>
            <!--ARTICLES LIST-->
            <section class="s-articles-list ms-section">
                <div class="section-bg"><img src="<?php echo get_template_directory_uri();?>/assets/images/bg-07.jpg" loading="lazy" alt=""></div>
                <div class="cn">
                    <div class="section-heading">
                        <h2 class="title h1"><?php echo get_sub_field( 'related_title' ); ?></h2>
                        <div class="subtitle"><?php echo get_sub_field( 'related_subtitle' ); ?></div>
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
                                $post_ID =$post->ID;
                            $make_tax =    get_sub_field( 'related_posts' );
                            $portfolio_posts =  get_sub_field( 'posts' );
                                // Push posts IDs to new array
                                $identifiers = array();
   if(($make_tax) || ($portfolio_posts))     {
if($make_tax) {
$args_1 = get_posts( array(
  'post_type' => 'portfolio',
  'post_count' => -1,
  'tax_query' => array(
    array(
      'taxonomy' => 'make',
      'field' => 'term_id',
      'terms' => $make_tax,
    )
  ),
) );
	foreach ( $args_1 as $post ) {
        			array_push( $identifiers, $post->ID );
	}
}
if($portfolio_posts) {
// Second query, specific posts query
$args_2 = get_posts( array(
  'post_type' => 'portfolio',
  'post_count' => -1,
  'include' => $portfolio_posts,
) );
	foreach ( $args_2 as $post ) {
		array_push( $identifiers, $post->ID );
	}
}
   } else {

   $terms = wp_get_object_terms($post->ID, 'make', array('orderby' => 'term_id', 'order' => 'ASC') );
    if ( !empty( $terms ) ) :
	 $project = array();
	    foreach ( $terms as $term ) {
		$project[] = $term->term_id;
	      }  endif;
	   $args_3 = get_posts( array(
		   'post_type' => 'portfolio',
		   'post_count' => -1,
		   'tax_query' => array(
			   array(
				   'taxonomy' => 'make',
				   'field' => 'term_id',
				   'terms' => $project[1],
			   )
		   ),
	   ) );
	   foreach ( $args_3 as $post ) {
		   array_push( $identifiers, $post->ID );
	   }
   }

// New query
$query = new WP_Query( array(
  'post_type' => 'portfolio',
  'post_status' => 'publish',
  'post_count' => -1,
  'post__in' => array_unique( $identifiers ),
  'post__not_in' => $post_ID,
) );

if ( $query->have_posts() ) :

  while ( $query->have_posts() ) :

    $query->the_post();?>

      <div class="swiper-slide">
          <div class="article-card">
              <div class="article-card__img">
			              <?php $image_repeater = get_field( 'overview_image' ); ?>
                  <?php if($image_repeater){?>
                      <img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                           loading="lazy"
                           alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>">
                  <?php }?>
               </div>
              <div class="article-card__content">
                  <div class="tags">
	                  <?php
	                  $terms = wp_get_object_terms($post->ID, 'portfolio-category', array('orderby' => 'term_id', 'order' => 'ASC') );
	                  if ( !empty( $terms ) ) :

		                  foreach ( $terms as $term ) { ?>
                              <div class="tag"><?php echo$term->name;?></div>
		                  <?php } ?>
	                  <?php endif;
	                  ?>
                  </div>
                  <h3 class="title"><?php echo get_the_title();?></h3>
                  <div class="desc"><?php echo get_field( 'preview_description' );?></div>
                  <a href="<?php the_permalink();?>" class="btn btn-3">
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

  <?php endwhile;

endif; wp_reset_postdata();?>


                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </section>
		<?php elseif ( get_row_layout() == 'products' ): ?>
         <?php
	                    $post_ID =$post->ID;
	                    $make_tax =    get_sub_field( 'products_category' );
	                    $portfolio_posts =  get_sub_field( 'products' );
	                    // Push posts IDs to new array
	                    $identifiers = array();
	                    if(($make_tax) || ($portfolio_posts))     {
		                    if($make_tax) {
			                    $args_1 = get_posts( array(
				                    'post_type' => 'product',
				                    'post_count' => -1,
				                    'tax_query' => array(
					                    array(
						                    'taxonomy' => 'make',
						                    'field' => 'term_id',
						                    'terms' => $make_tax,
					                    )
				                    ),
			                    ) );
			                    foreach ( $args_1 as $post ) {
				                    array_push( $identifiers, $post->ID );
			                    }
		                    }
		                    if($portfolio_posts) {
// Second query, specific posts query
			                    $args_2 = get_posts( array(
				                    'post_type' => 'product',
				                    'post_count' => -1,
				                    'include' => $portfolio_posts,
			                    ) );
			                    foreach ( $args_2 as $post ) {
				                    array_push( $identifiers, $post->ID );
			                    }
		                    }
	                    } else {

		                    $terms = wp_get_object_terms($post->ID, 'make', array('orderby' => 'term_id', 'order' => 'ASC') );
		                    if ( !empty( $terms ) ) :
			                    $project = array();
			                    foreach ( $terms as $term ) {
				                    $project[] = $term->term_id;
			                    }  endif;
		                    $args_3 = get_posts( array(
			                    'post_type' => 'product',
			                    'post_count' => -1,
			                    'tax_query' => array(
				                    array(
					                    'taxonomy' => 'make',
					                    'field' => 'term_id',
					                    'terms' => $project[1],
				                    )
			                    ),
		                    ) );
		                    foreach ( $args_3 as $post ) {
			                    array_push( $identifiers, $post->ID );
		                    }
	                    }

	                    // New query
	                    $query = new WP_Query( array(
		                    'post_type' => 'product',
		                    'post_status' => 'publish',
		                    'post_count' => -1,
		                    'post__in' => array_unique( $identifiers ),
		                    'post__not_in' => $post_ID,
	                    ) );

	                    if ( $query->have_posts() ) :?>
            <!--PRODUCTS-->
            <section class="s-products ms-section">
                <div class="cn">
                    <div class="section-heading section-heading--simple">
                        <h2 class="title h1"><?php echo get_sub_field( 'products_title' ); ?></h2>
                        <div class="subtitle"><?php echo get_sub_field( 'products_subtitle' ); ?></div>
                    </div>
                    <div class="products-list">


		                   <?php while ( $query->have_posts() ) :

			                    $query->the_post();?>

                                <div class="product-card">
                                    <div class="product-card__img"><img src="images/img-03.jpg" loading="lazy" alt=""></div>
                                    <div class="product-card__content">
                                        <h3 class="title"><?php echo get_the_title();?></h3>
                                        <div class="subtitle">2004-2011</div>
                                        <div class="btn-group">
                                            <a href="<?php the_permalink();?>" class="btn btn-2">From $6.95</a>
                                            <a href="#" class="btn btn-2">From $6.95</a>
                                        </div>
                                    </div>
                                </div>
		                    <?php endwhile;?>





                    </div>
                    <div class="section-btn"><a href="#" class="btn btn-1">Show more</a></div>
                </div>
            </section>
		                    <?php endif; wp_reset_postdata();?>
		<?php elseif ( get_row_layout() == 'services' ): ?>
            <!--SERVICES-->
            <section class="s-services-main ms-section">
                <div class="s-services-main__head">
                    <div class="section-bg"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-02.png" loading="lazy" alt=""></div>
                    <div class="cn">
                        <div class="section-heading">
                            <h2 class="title h1">Brake Caliper Refurbishment Services</h2>
                            <div class="subtitle">With years of experience, our company specializes in refurbishing brake calipers for cars. We have a team of skilled professionals dedicated to providing high-quality services to customers worldwide.</div>
                            <div class="decorated-title decorated-title--row-left">
                                <div class="small-title small-title--white">Our services</div>
                                <div class="line-decor line-decor--white"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cn">
                    <div class="services-list">
                        <div class="service-item">
                            <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
                            <h3 class="title">Brake Caliper Refurbishment Un-Seize & Repair Service</h3>
                            <div class="desc">Our team specializes in refurbishing brake calipers to restore their performance and appearance. If you don’t think you need a complete refurbishment.</div>
                            <a href="#" class="btn btn-2">
                                <span>Read more</span>
                                <span class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                  <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                </svg>
            </span>
                            </a>
                        </div>
                        <div class="service-item">
                            <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
                            <h3 class="title">Engineering & ReManufacture and Coatings</h3>
                            <div class="desc">We have incredible engineering capabilities at BCS. Aside from our on-site engineer with almost 40 years experience in manual turning, milling,</div>
                            <a href="#" class="btn btn-2">
                                <span>Read more</span>
                                <span class="icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                  <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                </svg>
            </span>
                            </a>
                        </div>
                        <div class="service-item">
                            <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
                            <h3 class="title">High-End Brake Caliper Painting</h3>
                            <div class="desc">With our High-End caliper painting service, we can provide all OEM colours for Brembo brake calipers. We can also replace logos.</div>
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
				<?php endif;
		// End loop.
	endwhile;
// No value.
else :
	// Do something...
endif; ?>
    <!--STICKY CALLBACK-->
    <div class="sticky-callback">
        <div class="btn-callback">
            <img src="<?php echo get_template_directory_uri();?>/assets/images/icons/icon-11.svg" loading="lazy" alt="">
            <img src="<?php echo get_template_directory_uri();?>/assets/images/icons/close-01.svg" loading="lazy" alt="">
        </div>

        <div class="tooltip">Need A quick response? We’re here to help</div>

        <div class="form">
            <div class="form__head">
                <div class="icon"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/icon-11.svg" loading="lazy" alt=""></div>
                <div>Get a callback</div>
            </div>
            <div class="form__body">
                <div class="text">Leave your contact information at this form and we’ll contact you to help you as soon
                    as possible
                </div>
                <form>
                    <div class="form-group">
                        <input type="email" class="input" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <input type="tel" class="input" placeholder="Mobile Phone">
                    </div>
                    <div class="form-group btn-group">
                        <button type="submit" class="btn btn-8">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
get_footer();
