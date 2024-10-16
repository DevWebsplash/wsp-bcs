<?php
/*
Template Name: Products

*/
get_header ();
// Отримання значень із GET-запиту
$selected_posts = !empty($_GET['custom_filter']) ? $_GET['custom_filter'] : array();

// Побудова WP_Query з meta_query для фільтрації постів
$args = array(
	'post_type' => 'post',  // або твій кастомний тип постів
	'meta_query' => array(
		array(
			'key' => 'your_custom_field',  // змінити на ключ кастомного поля
			'value' => $selected_posts,    // передані значення з GET-запиту
			'compare' => 'IN',             // для фільтрації за кількома значеннями
		),
	),
);

$query = new WP_Query($args);

if ($query->have_posts()) :
	while ($query->have_posts()) : $query->the_post();
		// Виведення постів
		the_title();
	endwhile;
	wp_reset_postdata();
else :
	echo 'Пости не знайдені';
endif;

?>
<form method="GET" action="">
    <label for="custom_filter">Фільтрувати за постами:</label>
    <select name="custom_filter[]" multiple>
			<?php
			// Отримання всіх постів, які можна вибрати
			$all_posts = get_posts(array('post_type' => 'post', 'numberposts' => -1));
			foreach ($all_posts as $post) {
				echo '<option value="' . $post->ID . '">' . $post->post_title . '</option>';
			}
			?>
    </select>
    <button type="submit">Фільтрувати</button>
</form>
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
						<option data-category="" value="portfolio_category">Project Type</option>
						<option data-category="" value="portfolio_category">Project Type</option>
						<?php
						// Get the parent terms of the 'make' taxonomy
						$terms = get_terms ('portfolio_category');
						// Loop through parent terms and set active class if it matches current or parent
						foreach ($terms as $term) { ?>
							<option data-category="<?php echo esc_attr ($term->term_id); ?>" value="<?php echo esc_attr ($term->slug); ?>"><?php echo esc_html ($term->name); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="custom-select">
					<select name="product-used" id="" class="portfolio-cat__select">
						<option data-used="" value="product_used">Products Used</option>
						<option data-used="" value="product_used">Products Used</option>
						<?php
						// Get the parent terms of the 'product_used' taxonomy
						$terms = get_terms ('product_used');
						// Loop through parent terms and set active class if it matches current or parent
						foreach ($terms as $term) { ?>
							<option data-used="<?php echo esc_attr ($term->term_id); ?>" value="<?php echo esc_attr ($term->slug); ?>"><?php echo esc_html ($term->name); ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="custom-select">
					<select name="city-state" id="" class="portfolio-cat__select">
						<option data-city-state="" value="city_state">City & State</option>
						<option data-city-state="" value="city_state">City & State</option>
						<?php
						// Get the parent terms of the 'state' taxonomy
						$terms = get_terms ('state');
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
						<option value="oldest">Oldest</option>
						<option value="increase">By name A-Z</option>
						<option value="reduction">By name Z-A</option>
					</select>
				</div>
				<button class="btn btn-1 js-reset-filtering">Reset All</button>
			</div>
		</div>
		<!--PRODUCTS-->
		<section class="s-products-main ms-section">
			<div class="cn">
				<div class="section-heading">
					<div class="decorated-title decorated-title--column-center">
						<div class="small-title small-title--gray">DISCOVER</div>
						<div class="line-decor line-decor--red"></div>
					</div>
					<h2 class="title h1"><?php echo get_field('product_title', 'option'); ?></h2>
					<div class="subtitle"><?php echo get_field('products_subtitle', 'option'); ?></div>
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
<?php get_footer (); ?>
