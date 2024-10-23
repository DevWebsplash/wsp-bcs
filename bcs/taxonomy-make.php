<?php get_header();
$queried_object = get_queried_object () ;
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
      <?php echo render_vehicle_search_form(); ?>
<!--      <div class="vehicles-search">-->
<!---->
<!--          <div class="form-row">-->
<!--            <div class="custom-select">-->
<!--	            -->
<!---->
<!--                <select data-make>-->
<!--                    <option value="">Select Make</option>-->
<!--			            --><?php
//			            // Get the parent terms of the 'make' taxonomy
//			            $terms = get_terms('make', array('parent' => 0));
//
//			            // Get the current term being viewed (if any)
//						            $queried_object = get_queried_object();
//
//			            // Initialize variable for the parent term ID
//			            $queried_object_term_id = null;
//
//			            // Check if current term exists and if it's a child, get the parent term ID
//			            if ($queried_object && $queried_object->parent != 0) {
//							  $queried_object_term_id = $queried_object->parent;
//			            } elseif ($queried_object) {
//							 $queried_object_term_id = $queried_object->term_id;
//			            }
//
//			            // Loop through parent terms and set active class if it matches current or parent
//			            foreach ($terms as $term) {
//				            // Check if the term is the current term or its parent
//				            $is_active = ($term->term_id == $queried_object_term_id) ? ' class="active" selected' : '';
//				            ?>
<!--                      <option data-make="--><?php //echo esc_attr($term->term_id); ?><!--" value="--><?php //echo esc_attr($term->slug); ?><!--"--><?php //echo $is_active; ?><!-->-->
<!--						            --><?php //echo esc_html($term->name); ?>
<!--                      </option>-->
<!--			            --><?php //} ?>
<!--                </select>-->
<!--            </div>-->
<!--              <div class="custom-select">-->
<!---->
<!--                  <select data-model>-->
<!--                      <option value="">Select Model</option>-->
<!--					          --><?php
//					          // Check if there is a current term and if it's a child term
//					          if ($queried_object && $queried_object->parent != 0) {
//						          // Get child terms (models) of the current parent term
//						          $child_terms = get_terms('make', array('parent' => $queried_object->parent));
//
//						          foreach ($child_terms as $child_term) {
//							          // Check if the child term is the current term
//							          $is_active = ($queried_object->term_id == $child_term->term_id) ? ' class="active" selected' : '';
//							          ?>
<!--                          <option data-model="--><?php //echo esc_attr($child_term->term_id); ?><!--" value="--><?php //echo esc_attr($child_term->slug); ?><!--"--><?php //echo $is_active; ?><!-->-->
<!--									          --><?php //echo esc_html($child_term->name); ?>
<!--                          </option>-->
<!--						          --><?php //}
//					          } elseif ($queried_object && $queried_object->parent == 0) {
//						          // If the current term is a parent, get its children and display them
//						          $child_terms = get_terms('make', array('parent' => $queried_object->term_id));
//
//						          foreach ($child_terms as $child_term) {
//							          ?>
<!--                          <option data-model="--><?php //echo esc_attr($child_term->term_id); ?><!--" value="--><?php //echo esc_attr($child_term->slug); ?><!--">-->
<!--									          --><?php //echo esc_html($child_term->name); ?>
<!--                          </option>-->
<!--						          --><?php //}
//					          } ?>
<!--                  </select>-->
<!--              </div>-->
<!--            <div class="custom-select">-->
<!--              <select data-trim>-->
<!--                <option>Select Trim</option>-->
<!--                <option data-trim="" value="">Asia</option>-->
<!---->
<!--              </select>-->
<!--            </div>-->
<!--            <div class="btn-group">-->
<!--              <a href="" class="btn btn-1">Search</a>-->
<!--            </div>-->
<!--          </div>-->
<!--        </form>-->
<!--      </div>-->
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
	                <?php $image_repeater = get_field( 'preview_image' ); ?>
                    <a href="<?php the_permalink();?>" class="img"><?php if($image_repeater){?>
                            <img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                 loading="lazy"
                                 alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>">
	                    <?php }?></a>
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
<?php
$post_ID =$post->ID;
$make_tax =  get_field( 'portfolio_category' ,$queried_object );
$portfolio_posts =  get_field( 'portfolio_posts' ,$queried_object );

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
	$args_3 = get_posts( array(
		'post_type' => 'portfolio',
		'post_count' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'make',
				'field' => 'term_id',
				'terms' => $queried_object->term_id,
			)
		),
	) );
	foreach ( $args_3 as $post ) {
		array_push( $identifiers, $post->ID );
	}

}

if($identifiers){
	// New query
	$query = new WP_Query( array(
		'post_type' => 'portfolio',
		'post_status' => 'publish',
		'post_count' => 9,
		'post__in' => array_unique( $identifiers ),
	) );

	if ( $query->have_posts() ) :?>
<!--SPECIALIST REVIEWS-->
<section class="s-specialists-reviews ms-section">
  <div class="section-bg"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-01.png" loading="lazy" alt=""></div>
  <div class="cn cn--big">
    <div class="section-heading">
      <div class="decorated-title decorated-title--column-center">
        <div class="small-title small-title--white">DISCOVER</div>
        <div class="line-decor line-decor--red"></div>
      </div>
      <h2 class="title h1"><?php echo get_field('portfolio_title', 'option'); ?></h2>
      <div class="subtitle"><?php echo get_field('portfolio_subtitle', 'option'); ?></div>
    </div>

    <div class="s-specialists-reviews__list">
		 <?php   while ( $query->have_posts() ) :
			    $query->the_post();?>
                <div class="sr-item">
                    <div class="sr-item__img"><?php $image_repeater = get_field( 'overview_image' ); ?>
	                    <?php if($image_repeater){?>
                          <img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                               loading="lazy"
                               alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>">
	                    <?php }?></div>
                    <div class="sr-item__content">
                        <h3 class="title h2"><?php echo get_the_title();?></h3>
                        <div class="tags">
	                        <?php
	                        $terms = wp_get_object_terms($post->ID, 'portfolio_category', array('orderby' => 'term_id', 'order' => 'ASC') );
	                        if ( !empty( $terms ) ) :
		                        foreach ( $terms as $term ) { ?>
                                <div class="tag"><?php echo$term->name;?></div>
		                        <?php } ?>
	                        <?php endif;
	                        ?>
                        </div>
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
		    <?php endwhile; ?>
    </div>
  </div>
</section>
<?php endif; wp_reset_postdata(); } ?>
<!--SERVICES-->
<section class="s-services-main ms-section">
  <div class="s-services-main__head">
    <div class="section-bg"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-02.png" loading="lazy" alt=""></div>
    <div class="cn">
      <div class="section-heading">
        <h2 class="title h1"><?php echo get_field('services_title', 'option'); ?></h2>
        <div class="subtitle"><?php echo get_field('services_subtitle', 'option'); ?></div>
        <div class="decorated-title decorated-title--row-left">
          <div class="small-title small-title--white">Our services</div>
          <div class="line-decor line-decor--white"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="cn">
    <div class="services-list">

	    <?php
	    $featured_posts = get_field ('services',$queried_object);
	    if ($featured_posts): ?>
		    <?php foreach ($featured_posts as $post):
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
	    <?php endif;
	    wp_reset_postdata ();?>
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
<?php
$post_ID = $post->ID;
$make_tax = get_field ('products_category',$queried_object);
$portfolio_posts = get_field ('products',$queried_object);
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
            <div class="section-heading">
                <h2 class="title h1"><?php echo get_field('product_title', 'option'); ?></h2>
                <div class="subtitle"><?php echo get_field('products_subtitle', 'option'); ?></div>
            </div>
            <div class="products-list">
							<?php while ($query->have_posts ()) :
								$query->the_post (); ?>
                  <div class="product-card">
                      <div class="product-card__img">
                          <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
														<?php if ( $product->get_image_id() ) : ?>
                                <img src="<?php echo wp_get_attachment_url( $product->get_image_id() ); ?>" loading="lazy" alt="<?php echo esc_attr( $product->get_name() ); ?>">
														<?php else : ?>
                                <!-- Fallback static image -->
                                <img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" loading="lazy" alt="No image available">
														<?php endif; ?>
                          </a>
                      </div>
                      <div class="product-card__content">
                          <h3 class="title"><?php echo esc_html( $product->get_name() ); ?></h3>
                          <div class="subtitle">
														<?php
														// Check if product is variable
														if ( $product->is_type( 'variable' ) ) {
															// Get minimum and maximum prices for the variable product
															echo $product->get_price_html(); // WooCommerce function to display variable product price range
														} else {
															// Display regular price for simple products
															echo wc_price( $product->get_price() );
														}
														?>
                          </div>
                          <div class="btn-group">
														<?php
														// Generate a Buy Now button with WooCommerce's "add_to_cart_url" function
														$add_to_cart_url = esc_url( $product->add_to_cart_url() );
														?>
                              <a href="<?php echo $add_to_cart_url; ?>" class="btn btn-2" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>">
                                  Buy Now  </a>
                          </div>
                      </div>
                  </div>
							<?php endwhile; ?>
            </div>
            <div class="section-btn"><a href="/staging/products/brake-caliper-paint-kits/" class="btn btn-1">View all</a></div>
        </div>
    </section>
<?php endif;
wp_reset_postdata (); ?>

<?php echo get_template_part( 'includes/content', 'reviews' ); ?>

<!--BANNER-->
<section class="s-banner-2 ms-section">
    <div class="section-bg"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-03.png" loading="lazy"
                                 alt=""></div>
    <div class="cn">
        <div class="s-banner-2__inner">
            <div class="s-banner-2__left">
                <div class="decorated-title decorated-title--column-left">
                    <div class="small-title small-title--white"><?php echo get_field('cto_category_small_title', 'option');?></div>
                    <div class="line-decor line-decor--white"></div>
                </div>
                <h2 class="title h1"><?php echo get_field('cto_category_title', 'option');?></h2>
            </div>
            <div class="s-banner-2__right">
                <div class="numbers">
									<?php  if ( have_rows( 'cto_category_items', 'option' ) ): ?>
										<?php while ( have_rows( 'cto_category_items', 'option' ) ) : the_row(); ?>
											<?php $image_repeater = get_sub_field( 'icon' ); ?>
                          <div class="item">
                              <div class="title">
                                  <div class="icon">
                                      <img src="<?php echo esc_url( $image_repeater['url'] ); ?>" loading="lazy" alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>">
                                  </div>
                                  <div><?php echo get_sub_field( 'title' ); ?></div>
                              </div>
                              <div class="desc"><?php echo get_sub_field( 'description' ); ?></div>
                          </div>
										<?php endwhile;?>
									<?php endif; ?>
                </div>
                <div class="text"><?php echo get_field('cto_category_text', 'option');?></div>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>
