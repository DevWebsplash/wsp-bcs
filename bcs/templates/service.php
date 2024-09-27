<?php
/*
Template Name: Services

*/
get_header();
?>
<?php
// Check value exists.
if ( have_rows( 'services_flexible_content' ) ):
	$i = 0;
	// Loop through rows.
	while ( have_rows( 'services_flexible_content' ) ) : the_row();
		$i ++;
		// Case: Paragraph layout.
		if ( get_row_layout() == 'overview' ):?>
            <!--HERO variant 2-->
            <section class="s-hero s-hero--variant-2 ms-section">
                <div class="cn cn--big">
                    <div class="inner-content">
						<?php $image_repeater = get_sub_field( 'overview_image' ); ?>
                <div class="inner-content__img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                      loading="lazy"
                                      alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>">
                </div>
                        <div class="empty"></div>
                        <div class="inner-content__text">
                            <div class="section-heading">
                                <h1 class="title h1"><?php echo get_sub_field( 'overview_title' ); ?></h1>
                            </div>
                            <div class="text">
	                            <?php echo get_sub_field( 'overview_text' ); ?>
                            </div>
	                        <?php
	                        $link = get_sub_field( 'overview_button' );
	                        if ( $link ):
		                        $link_url    = $link['url'];
		                        $link_title  = $link['title'];
		                        $link_target = $link['target'] ? $link['target'] : '_self';
		                        ?>
                              <a href="<?php echo esc_url( $link_url ); ?>" class="btn btn-8"
                                 target="<?php echo esc_attr( $link_target ); ?>">
                                <?php echo esc_html( $link_title ); ?>
                              </a>
	                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
		<?php elseif ( get_row_layout() == 'services' ): ?>
            <!--SERVICES-->
            <section class="s-services ms-section">
                <div class="cn">
                    <div class="section-heading">
                        <div class="decorated-title decorated-title--column-center">
                            <div class="small-title small-title--gray">DISCOVER</div>
                            <div class="line-decor line-decor--red"></div>
                        </div>
                        <h2 class="title h1"><?php echo get_sub_field( 'services_title' ); ?></h2>
                        <div class="subtitle"><?php echo get_sub_field( 'services_subtitle' ); ?></div>
                    </div>

                    <div class="s-services__list">
					<?php  if ( have_rows( 'services_repeater' ) ): ?>
						<?php while ( have_rows( 'services_repeater' ) ) : the_row(); ?>
                        <div class="service-item">
	                        <?php $image_repeater = get_sub_field( 'image' ); ?>
                            <div class="service-item__img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                                                 loading="lazy"
                                                                 alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>">
                            </div>
                            <div class="service-item__content">
                                <h3 class="block-title h2"><?php echo get_sub_field( 'title' ); ?></h3>
                                <div class="desc"><?php echo get_sub_field( 'text' ); ?></div>
                                <ul class="info-list">
							<?php  if ( have_rows( 'list' ) ): ?>
								<?php while ( have_rows( 'list' ) ) : the_row(); ?>
                                    <li>
                                        <div class="title"><?php echo get_sub_field( 'list_title' ); ?></div>
                                        <div><?php echo get_sub_field( 'list_description' ); ?></div>
                                    </li>
								<?php endwhile; ?>
							<?php endif; ?>
                                </ul>
	                            <?php
	                            $link = get_sub_field( 'button' );
	                            if ( $link ):
		                            $link_url    = $link['url'];
		                            $link_title  = $link['title'];
		                            $link_target = $link['target'] ? $link['target'] : '_self';
		                            ?>
                                  <a href="<?php echo esc_url( $link_url ); ?>" class="btn btn-1"
                                     target="<?php echo esc_attr( $link_target ); ?>">
				                            <?php echo esc_html( $link_title ); ?>
                                  </a>
	                            <?php endif; ?>
                            </div>
                        </div>
						<?php endwhile; ?>
	                <?php endif; ?>

                    </div>
                </div>
            </section>
		<?php elseif ( get_row_layout() == 'testimonials' ): ?>
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
		<?php elseif ( get_row_layout() == 'cto' ): ?>
            <!--BANNER-->
            <section class="s-banner-2 ms-section">
                <div class="section-bg"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg-06.jpg" loading="lazy" alt=""></div>
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
                                <h3 class="title h2"><?php echo get_sub_field( 'list_description' ); ?></h3>
                                <div class="subtitle"><?php echo get_sub_field( 'list_description' ); ?></div>
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

		<?php elseif ( get_row_layout() == 'portfolio' ): ?>
        	<?php
											$make_tax =    get_sub_field( 'portfolio_taxonomy' );
											$portfolio_posts =  get_sub_field( 'portfolio_posts' );
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
											}

											// New query
											$query = new WP_Query( array(
												'post_type' => 'portfolio',
												'post_status' => 'publish',
												'post_count' => -1,
												'post__in' => array_unique( $identifiers ),
											) );

											if ( $query->have_posts() ) :?>
        <!--ARTICLES LIST-->
        <section class="s-articles-list ms-section">
	        <?php $image_repeater = get_sub_field( 'portfolio_background' ); ?>
            <div class="section-bg"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                                loading="lazy"
                                                alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>">
            </div>
            <div class="cn">
                <div class="section-heading">
                    <h2 class="title h1"><?php echo get_sub_field( 'portfolio_title' ); ?></h2>
                    <div class="subtitle"><?php echo get_sub_field( 'subtitle' ); ?></div>
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
																					$terms = wp_get_object_terms($post->ID, 'portfolio_category', array('orderby' => 'term_id', 'order' => 'ASC') );
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

												<?php endwhile;?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
		<?php endif; wp_reset_postdata();?>
				<?php elseif ( get_row_layout() == 'faq' ): ?>
            <!--KNOWLEDGE variant 3-->
            <section class="s-knowledge s-knowledge--variant-3 ms-section">
                <div class="cn">
                    <div class="section-heading section-heading--simple">
                        <h2 class="title h1"><?php echo get_sub_field( 'faq_title' ); ?></h2>
                        <div class="subtitle"><?php echo get_sub_field( 'faq_subtitle' ); ?></div>
                    </div>
                    <div class="acc">
					<?php  if ( have_rows( 'faq_repeater' ) ): ?>
						<?php while ( have_rows( 'faq_repeater' ) ) : the_row(); ?>
                        <div class="acc-item">
                            <div class="acc-head"><?php echo get_sub_field( 'Question' ); ?></div>
                            <div class="acc-body">
                                <div class="inner">
                                    <div class="text"><?php echo get_sub_field( 'answer' ); ?></div>
                                </div>
                            </div>
                        </div>
						<?php endwhile;?>
					<?php endif; ?>
                    </div>
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
		<?php endif;
		// End loop.
	endwhile;
// No value.
else :
	// Do something...
endif; ?>




<?php get_footer(); ?>