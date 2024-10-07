<!--TESTIMONIALS-->
<section class="s-testimonials-main ms-section">
	<div class="s-testimonials-main__head">
		<div class="section-bg"><img src="<?php echo get_template_directory_uri (); ?>/assets/images/bg-04.png"
		                             loading="lazy" alt=""></div>
		<div class="cn">
			<div class="section-heading">
				<h2 class="title h1"><?php echo get_field('reviews_title', 'option');?></h2>
				<div class="subtitle"><?php echo get_field('reviews_subtitle', 'option');?></div>
			</div>
			<div class="decorated-title decorated-title--row-left">
				<div class="small-title small-title--white"><?php echo get_field('reviews_small_title', 'option');?></div>
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
				<?php  if ( have_rows( 'reviews_option', 'option' ) ): ?>
					<?php while ( have_rows( 'reviews_option', 'option' ) ) : the_row(); ?>
						<?php $image_repeater = get_sub_field( 'image' ); ?>
				<div class="swiper-slide">
					<div class="item">
						<div class="top-line">
							<div class="img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
							                      loading="lazy"
							                      alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></div>
							<?php $image_repeater = get_sub_field( 'stars' ); ?>
							<div class="ratting"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
							                             loading="lazy"
							                             alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></div>
						</div>
						<div class="name"><?php echo get_sub_field( 'name' ); ?></div>
						<div class="title"><?php echo get_sub_field( 'title' ); ?></div>
						<div class="text"><?php echo get_sub_field( 'text' ); ?></div>
					</div>
				</div>
					<?php endwhile;?>
				<?php endif; ?>
			</div>
			<div class="swiper-pagination"></div>
		</div>

		<div class="b-popularity ms-section">
			<div class="item">
							<?php $image_repeater = get_sub_field( 'trustpilot_image' ); ?>
				<div class="img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                      loading="lazy"
                                      alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></div>
				<div class="text"><span><?php echo get_field('trustpilot__rate', 'option');?></span> <?php echo get_field('trustpilot_number', 'option');?></div>
			</div>
			<div class="item">
							<?php $image_repeater = get_sub_field( 'google_image_' ); ?>
				<div class="img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                      loading="lazy"
                                      alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></div>
				<div class="text"><span><?php echo get_field('google_rate', 'option');?></span> <?php echo get_field('google_number', 'option');?></div>
			</div>
			<div class="item">
							<?php $image_repeater = get_sub_field( 'facebook_image' ); ?>
				<div class="img"><img src="<?php echo esc_url( $image_repeater['url'] ); ?>"
                                      loading="lazy"
                                      alt="<?php echo esc_attr( $image_repeater['alt'] ); ?>"></div>
				<div class="text"><span><?php echo get_field('facebook_rate', 'option');?></span> <?php echo get_field('facebook_number', 'option');?></div>
			</div>
		</div>
	</div>
</section>