<?php get_header();
?>

<!-- HTML Content here  -->
<!--VEHICLES-->
<section class="s-vehicles ms-section">
  <div class="s-vehicles__head">
    <div class="cn">
      <div class="section-heading">
        <h1 class="title h1">Find Your Vehicle</h1>
        <div class="subtitle">Select your vehicle make, model, and trim to get personalized recommendations.</div>
      </div>
      <div class="vehicles-search">

          <div class="form-row">
            <div class="custom-select">
	            <?php $queried_object = get_queried_object () ;?>

                <select data-make>
                    <option value="">Select Make</option>
			            <?php
			            // Get the parent terms of the 'make' taxonomy
			            $terms = get_terms('make', array('parent' => 0));

			            // Get the current term being viewed (if any)
						            $queried_object = get_queried_object();

			            // Initialize variable for the parent term ID
			            $queried_object_term_id = null;

			            // Check if current term exists and if it's a child, get the parent term ID
			            if ($queried_object && $queried_object->parent != 0) {
							  $queried_object_term_id = $queried_object->parent;
			            } elseif ($queried_object) {
							 $queried_object_term_id = $queried_object->term_id;
			            }

			            // Loop through parent terms and set active class if it matches current or parent
			            foreach ($terms as $term) {
				            // Check if the term is the current term or its parent
				            $is_active = ($term->term_id == $queried_object_term_id) ? ' class="active" selected' : '';
				            ?>
                      <option data-make="<?php echo esc_attr($term->term_id); ?>" value="<?php echo esc_attr($term->slug); ?>"<?php echo $is_active; ?>>
						            <?php echo esc_html($term->name); ?>
                      </option>
			            <?php } ?>
                </select>
            </div>
              <div class="custom-select">

                  <select data-model>
                      <option value="">Select Model</option>
					          <?php
					          // Check if there is a current term and if it's a child term
					          if ($queried_object && $queried_object->parent != 0) {
						          // Get child terms (models) of the current parent term
						          $child_terms = get_terms('make', array('parent' => $queried_object->parent));

						          foreach ($child_terms as $child_term) {
							          // Check if the child term is the current term
							          $is_active = ($queried_object->term_id == $child_term->term_id) ? ' class="active" selected' : '';
							          ?>
                          <option data-model="<?php echo esc_attr($child_term->term_id); ?>" value="<?php echo esc_attr($child_term->slug); ?>"<?php echo $is_active; ?>>
									          <?php echo esc_html($child_term->name); ?>
                          </option>
						          <?php }
					          } elseif ($queried_object && $queried_object->parent == 0) {
						          // If the current term is a parent, get its children and display them
						          $child_terms = get_terms('make', array('parent' => $queried_object->term_id));

						          foreach ($child_terms as $child_term) {
							          ?>
                          <option data-model="<?php echo esc_attr($child_term->term_id); ?>" value="<?php echo esc_attr($child_term->slug); ?>">
									          <?php echo esc_html($child_term->name); ?>
                          </option>
						          <?php }
					          } ?>
                  </select>
              </div>
            <div class="custom-select">
              <select data-trim>
                <option>Select Trim</option>
                <option data-trim="" value="">Asia</option>

              </select>
            </div>
            <div class="btn-group">
              <a href="" class="btn btn-1">Search</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="cn">
    <div class="s-vehicles__list">
        <?php $args = array (
        'post_type' => 'vehicle',
        'tax_query' => array (
        array (
        'taxonomy' => $queried_object->taxonomy,
        'field' => 'slug',
        'terms' => $queried_object->slug,
        ),
        ),
        ) ;
        $query = new WP_Query ($args) ;?>
	    <?php
	    // The Query.
	    $the_query = new WP_Query( $args );

	    // The Loop.
	    if ( $the_query->have_posts() ) {

		    while ( $the_query->have_posts() ) {
			    $the_query->the_post();?>
                <div class="vehicle-card">
                    <a href="<?php the_permalink();?>" class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-01.png" loading="lazy" alt=""></a>
	                <?php
	                $terms = wp_get_object_terms($post->ID, 'make', array('orderby' => 'term_id', 'order' => 'ASC') );
	                if ( !empty( $terms ) ) :
		                $project = array();
		                foreach ( $terms as $term ) {
			                $project[] = $term->name;
		                } ?>
                        <div class="brand"><?php echo $project[0];?></div>
                        <div class="model"><?php echo $project[1];?></div>
	                <?php endif;
	                ?>
                    <div class="info"><?php echo get_the_title();?></div>
                    <a href="<?php the_permalink();?>" class="btn btn-2">View</a>
                </div>
		    <?php }
	    }
	    wp_reset_postdata();
	    ?>
    </div>
  </div>
</section>

<!--SPECIALIST REVIEWS-->
<section class="s-specialists-reviews ms-section">
  <div class="section-bg"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-01.png" loading="lazy" alt=""></div>
  <div class="cn cn--big">
    <div class="section-heading">
      <div class="decorated-title decorated-title--column-center">
        <div class="small-title small-title--white">DISCOVER</div>
        <div class="line-decor line-decor--red"></div>
      </div>
      <h2 class="title h1">Brake Caliper Specialists Reviews</h2>
      <div class="subtitle">Browse through our showcase of projects</div>
    </div>

    <div class="s-specialists-reviews__list">

      <div class="sr-item">
        <div class="sr-item__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
        <div class="sr-item__content">
          <h3 class="title h2">Fiat Doblo 2016 brake caliper painting in Leeds</h3>
          <div class="tags">
            <div class="tag">Engineering services</div>
            <div class="tag">Painting</div>
            <div class="tag">2 piston</div>
          </div>
          <div class="desc">If you are looking for experienced and highly professional brake caliper painting and refurbishment then look no further than Bespoke Detailing Solutions. We specialise in all aspect of car detailing and care to make sure your vehicle is looking its best.</div>
          <a href="#" class="btn btn-3">
            <span>Read more</span>
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                  <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                </svg>
              </span>
          </a>
        </div>
      </div>

      <div class="sr-item">
        <div class="sr-item__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
        <div class="sr-item__content">
          <h3 class="title h2">Fiat Doblo 2016 brake caliper painting in Leeds</h3>
          <div class="tags">
            <div class="tag">Engineering services</div>
            <div class="tag">Painting</div>
            <div class="tag">2 piston</div>
          </div>
          <div class="desc">If you are looking for experienced and highly professional brake caliper painting and refurbishment then look no further than Bespoke Detailing Solutions. We specialise in all aspect of car detailing and care to make sure your vehicle is looking its best.</div>
          <a href="#" class="btn btn-3">
            <span>Read more</span>
            <span class="icon">
                 <svg xmlns="http://www.w3.org/2000/svg" width="8" height="12" viewBox="0 0 8 12" fill="none">
                  <path d="M0.274414 10.2383L4.66358 5.83951L0.274414 1.44076L1.62566 0.0895081L7.37566 5.83951L1.62566 11.5895L0.274414 10.2383Z"/>
                </svg>
              </span>
          </a>
        </div>
      </div>

      <div class="sr-item">
        <div class="sr-item__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
        <div class="sr-item__content">
          <h3 class="title h2">Fiat Doblo 2016 brake caliper painting in Leeds</h3>
          <div class="tags">
            <div class="tag">Engineering services</div>
            <div class="tag">Painting</div>
            <div class="tag">2 piston</div>
          </div>
          <div class="desc">If you are looking for experienced and highly professional brake caliper painting and refurbishment then look no further than Bespoke Detailing Solutions. We specialise in all aspect of car detailing and care to make sure your vehicle is looking its best.</div>
          <a href="#" class="btn btn-3">
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
  </div>
</section>

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

<!--BANNER-->
<section class="s-banner-1 ms-section">
  <div class="s-banner-1__img"><div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div></div>
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
      <h2 class="title h1">Brake Caliper Products</h2>
      <div class="subtitle">Browse our selection of high-quality brake calipers.</div>
    </div>
    <div class="products-list">
      <div class="product-card">
        <div class="product-card__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-03.jpg" loading="lazy" alt=""></div>
        <div class="product-card__content">
          <h3 class="title">Porsche 993 911 front brake caliper repair kit for Brembo</h3>
          <div class="subtitle">2004-2011</div>
          <div class="btn-group">
            <a href="#" class="btn btn-2">From $6.95</a>
          </div>
        </div>
      </div>
      <div class="product-card">
        <div class="product-card__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-03.jpg" loading="lazy" alt=""></div>
        <div class="product-card__content">
          <h3 class="title">Alcon Prodrive 4 Pot Caliper Seal Kit</h3>
          <div class="subtitle">2004-2011</div>
          <div class="btn-group">
            <a href="#" class="btn btn-2">From $6.95</a>
          </div>
        </div>
      </div>
      <div class="product-card">
        <div class="product-card__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-03.jpg" loading="lazy" alt=""></div>
        <div class="product-card__content">
          <h3 class="title">Porsche 993 911 front brake caliper repair kit for Brembo</h3>
          <div class="subtitle">2004-2011</div>
          <div class="btn-group">
            <a href="#" class="btn btn-2">From $6.95</a>
          </div>
        </div>
      </div>
      <div class="product-card">
        <div class="product-card__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-03.jpg" loading="lazy" alt=""></div>
        <div class="product-card__content">
          <h3 class="title">Alcon Prodrive 4 Pot Caliper Seal Kit</h3>
          <div class="subtitle">2004-2011</div>
          <div class="btn-group">
            <a href="#" class="btn btn-2">From $6.95</a>
          </div>
        </div>
      </div>
      <div class="product-card">
        <div class="product-card__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-03.jpg" loading="lazy" alt=""></div>
        <div class="product-card__content">
          <h3 class="title">Porsche 993 911 front brake caliper repair kit for Brembo</h3>
          <div class="subtitle">2004-2011</div>
          <div class="btn-group">
            <a href="#" class="btn btn-2">From $6.95</a>
          </div>
        </div>
      </div>
      <div class="product-card">
        <div class="product-card__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-03.jpg" loading="lazy" alt=""></div>
        <div class="product-card__content">
          <h3 class="title">Alcon Prodrive 4 Pot Caliper Seal Kit</h3>
          <div class="subtitle">2004-2011</div>
          <div class="btn-group">
            <a href="#" class="btn btn-2">From $6.95</a>
          </div>
        </div>
      </div>
    </div>
    <div class="section-btn"><a href="#" class="btn btn-1">View all</a></div>
  </div>
</section>

<!--TESTIMONIALS-->
<section class="s-testimonials-main ms-section">
  <div class="s-testimonials-main__head">
    <div class="section-bg"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-04.png" loading="lazy" alt=""></div>
    <div class="cn">
      <div class="section-heading">
        <h2 class="title h1">Brake Caliper Reviews</h2>
        <div class="subtitle">Below are all of the places on the web where we have a presence and where people are able to review us.</div>
      </div>
      <div class="decorated-title decorated-title--row-left">
        <div class="small-title small-title--white">OUR REVIEWS</div>
        <div class="line-decor line-decor--white"></div>
      </div>
    </div>
  </div>

  <div class="cn">
    <div class="swiper testimonials-slider">
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
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake caliper painting in Leeds</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim sit aliqua dolor do amet sint. Velit officia consequat duis enim sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake caliper painting in Leeds</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake caliper painting in Leeds</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake caliper painting in Leeds</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>

    <div class="b-popularity ms-section">
      <div class="item">
        <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-trustpilot.png" loading="lazy" alt=""></div>
        <div class="text"><span>4.9</span> (294 reviews)</div>
      </div>
      <div class="item">
        <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-google.png" loading="lazy" alt=""></div>
        <div class="text"><span>4.4</span> (265 reviews)</div>
      </div>
      <div class="item">
        <div class="img"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-facebook.png" loading="lazy" alt=""></div>
        <div class="text"><span>50.000</span> followers</div>
      </div>
    </div>
  </div>
</section>

<!--BANNER-->
<section class="s-banner-2 ms-section">
  <div class="section-bg"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-03.png" loading="lazy" alt=""></div>
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
        <div class="numbers">
          <div class="item">
            <div class="title">
              <div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/award.svg" loading="lazy" alt=""></div>
              <div>10</div>
            </div>
            <div class="desc">Years in Business</div>
          </div>
          <div class="item">
            <div class="title">
              <div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/thumb-up.svg" loading="lazy" alt=""></div>
              <div>500+</div>
            </div>
            <div class="desc">Reviews from clients </div>
          </div>
        </div>
        <div class="text">With years of experience, our company specializes in refurbishing brake calipers for cars. We have a team of skilled professionals dedicated to providing high-quality services to customers worldwide.</div>
        <a href="#" class="btn btn-5">
          <span>Submit</span>
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


<?php get_footer(); ?>
