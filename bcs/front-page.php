<?php get_header();
/* Template Name: Home */
?>

<!--  <section class="b-hero align-center text-center">-->
<!--    <div class="cn cn--lg">-->
<!--      <h1 class="b-hero__title">--><?php //the_field( 'header_title1' ); ?><!--</h1>-->
<!--      <p>--><?php //the_field( 'header_subtitle1' ); ?><!--</p>-->
<!--      <a class="btn btn-white" href="--><?php //the_field( 'header_button_link1' ); ?><!--">--><?php //the_field( 'header_button_title1' ); ?><!--</a>-->
<!--    </div>-->
<!--  </section>-->

<!--VEHICLES-->
<section class="s-vehicles-simple ms-section">
  <div class="section-bg"><img src="<?php echo get_template_directory_uri();?>/assets/images/bg-08.jpg" loading="lazy" alt=""></div>
  <div class="cn">
    <div class="section-heading">
      <h1 class="title h1">Brake Refubrishment Service</h1>
      <div class="subtitle">Select your vehicle make, model, and trim to get personalized recommendations</div>
    </div>
    <div class="vehicles-search">
      <form>
        <div class="form-row">
          <div class="custom-select">
            <select>
              <option value="">Select Make</option>
              <option value="">Abarth</option>
              <option value="">Aixam</option>
              <option value="">Alfa Romeo</option>
              <option value="">Asia</option>
              <option value="">Aston Martin</option>
              <option value="">Audi</option>
              <option value="">Austin</option>
              <option value="">Bentley</option>
            </select>
          </div>
          <div class="custom-select">
            <select>
              <option value="">Select Model</option>
              <option value="">Aston Martin</option>
              <option value="">Audi</option>
              <option value="">Austin</option>
              <option value="">Bentley</option>
            </select>
          </div>
          <div class="custom-select">
            <select>
              <option value="">Select Trim</option>
              <option value="">Asia</option>
              <option value="">Aston Martin</option>
              <option value="">Audi</option>
              <option value="">Austin</option>
              <option value="">Bentley</option>
            </select>
          </div>
          <div class="btn-group">
            <button type="submit" class="btn btn-1">Search</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<!--WHY-->
<section class="s-why ms-section">
  <div class="cn">
    <div class="s-why__inner">
      <div class="s-why__img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
      <div class="s-why__content">
        <div class="section-heading">
          <h2 class="title h1">Why BCS?</h2>
          <div class="subtitle h2">We are the leading experts in Brake Caliper Refurbishment to the trade and owner driver</div>
        </div>
        <div class="desc">The friendliest people work here at BCS, the brake caliper refurbishment specialists and we are incredibly passionate about fulfilling our customers needs. We treat every customer as if they are the most important customer. Furthermore, if we could hug you over the phone, we would. We just happen to refurbish brake calipers, want us to refurbish yours?</div>
        <a href="#" class="btn btn-8">Get a quote</a>
      </div>
    </div>
  </div>
</section>

<!--SERVICES-->
<section class="s-services-main ms-section">
  <div class="s-services-main__head">
    <div class="section-bg"><img src="<?php echo get_template_directory_uri();?>/assets/images/bg-02.png" loading="lazy" alt=""></div>
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
        <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
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
        <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
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
        <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
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

<!--THREE COLUMN variant 2-->
<section class="s-three-column s-three-column--variant-2 ms-section">
  <div class="cn">
    <div class="section-heading">
      <div class="decorated-title decorated-title--column-center">
        <div class="small-title small-title--gray">DISCOVER</div>
        <div class="line-decor line-decor--red"></div>
      </div>
      <h2 class="title h1">Brake Caliper advantages</h2>
      <div class="subtitle">Browse our selection of high-quality brake calipers.</div>
    </div>

    <div class="s-three-column__list">
      <div class="item">
        <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/icon-01.svg" loading="lazy" alt=""></div>
        <h3 class="title">Customization</h3>
        <div class="desc">Our team specializes in refurbishing brake calipers to restore their performance and appearance.</div>
      </div>
      <div class="item">
        <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/icon-02.svg" loading="lazy" alt=""></div>
        <h3 class="title">Worldwide Shipping</h3>
        <div class="desc">We offer convenient worldwide shipping options to ensure your refurbished brake calipers reach you no matter where you are.</div>
      </div>
      <div class="item">
        <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/icon-03.svg" loading="lazy" alt=""></div>
        <h3 class="title">Product Customization</h3>
        <div class="desc">85% of jobs completed by our specializes within 24 hours</div>
      </div>
    </div>
    <div class="section-btn">
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

<!--SPECIALIST REVIEWS-->
<section class="s-specialists-reviews ms-section">
  <div class="section-bg"><img src="<?php echo get_template_directory_uri();?>/assets/images/bg-01.png" loading="lazy" alt=""></div>
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
        <div class="sr-item__img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
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
        <div class="sr-item__img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
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
        <div class="sr-item__img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
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

<!--BANNER-->
<section class="s-banner-2 ms-section">
  <div class="section-bg"><img src="<?php echo get_template_directory_uri();?>/assets/images/bg-03.png" loading="lazy" alt=""></div>
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
              <div class="icon"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/award.svg" loading="lazy" alt=""></div>
              <div>10</div>
            </div>
            <div class="desc">Years in Business</div>
          </div>
          <div class="item">
            <div class="title">
              <div class="icon"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/thumb-up.svg" loading="lazy" alt=""></div>
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

<!--COOPERATION-->
<section class="s-cooperation ms-section">
  <div class="cn cn--small">
    <div class="section-heading">
      <div class="decorated-title decorated-title--column-center">
        <div class="small-title small-title--gray">DISCOVER</div>
        <div class="line-decor line-decor--red"></div>
      </div>
      <h2 class="title h1">We work with major brand Calipers</h2>
      <div class="subtitle">We also work for and have done work for Porsche, Ferrari, Lamborghini, Noble, Norton Motorcycles, Maserati, BMW, Audi, Mercedes-Benz and many more. Most of the UK main dealers for sports and prestige makes are also regular customers of BCS Automotive.</div>
    </div>

    <div class="partners-logos">
      <div class="item"><img src="<?php echo get_template_directory_uri();?>/assets/images/partners-logos/logo-01.png" loading="lazy" alt=""></div>
      <div class="item"><img src="<?php echo get_template_directory_uri();?>/assets/images/partners-logos/logo-02.png" loading="lazy" alt=""></div>
      <div class="item"><img src="<?php echo get_template_directory_uri();?>/assets/images/partners-logos/logo-03.png" loading="lazy" alt=""></div>
      <div class="item"><img src="<?php echo get_template_directory_uri();?>/assets/images/partners-logos/logo-04.png" loading="lazy" alt=""></div>
      <div class="item"><img src="<?php echo get_template_directory_uri();?>/assets/images/partners-logos/logo-05.png" loading="lazy" alt=""></div>
      <div class="item"><img src="<?php echo get_template_directory_uri();?>/assets/images/partners-logos/logo-06.png" loading="lazy" alt=""></div>
      <div class="item"><img src="<?php echo get_template_directory_uri();?>/assets/images/partners-logos/logo-07.png" loading="lazy" alt=""></div>
      <div class="item"><img src="<?php echo get_template_directory_uri();?>/assets/images/partners-logos/logo-08.png" loading="lazy" alt=""></div>
      <div class="item"><img src="<?php echo get_template_directory_uri();?>/assets/images/partners-logos/logo-09.png" loading="lazy" alt=""></div>
    </div>

    <div class="swiper cooperation-slider">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="item">
            <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-07.jpg" loading="lazy" alt=""></div>
            <div class="subtitle">Matthew Stripling</div>
            <div class="title">Alpina UK Brand Manager</div>
            <div>Dear Richard.</div>
            <div>I wanted to write to you to express out thanks for your teams hard work in making uor customer very happy with his new
              brake calipers. Your companies professionalism was exemplary and I would without doubt recommend your service to
              anyone. We wish you every success.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-07.jpg" loading="lazy" alt=""></div>
            <div class="subtitle">Matthew Stripling</div>
            <div class="title">Alpina UK Brand Manager</div>
            <div>Dear Richard.</div>
            <div>I wanted to write to you to express out thanks for your teams hard work in making uor customer very happy with his new
              brake calipers. Your companies professionalism was exemplary and I would without doubt recommend your service to
              anyone. We wish you every success.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-07.jpg" loading="lazy" alt=""></div>
            <div class="subtitle">Matthew Stripling</div>
            <div class="title">Alpina UK Brand Manager</div>
            <div>Dear Richard.</div>
            <div>I wanted to write to you to express out thanks for your teams hard work in making uor customer very happy with his new
              brake calipers.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-07.jpg" loading="lazy" alt=""></div>
            <div class="subtitle">Matthew Stripling</div>
            <div class="title">Alpina UK Brand Manager</div>
            <div>Dear Richard.</div>
            <div>I wanted to write to you to express out thanks for your teams hard work in making uor customer very happy with his new
              brake calipers. Your companies professionalism was exemplary and I would without doubt recommend your service to
              anyone. We wish you every success.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-07.jpg" loading="lazy" alt=""></div>
            <div class="subtitle">Matthew Stripling</div>
            <div class="title">Alpina UK Brand Manager</div>
            <div>Dear Richard.</div>
            <div>I wanted to write to you to express out thanks for your teams hard work in making uor customer very happy with his new
              brake calipers. Your companies professionalism was exemplary and I would without doubt recommend your service to
              anyone. We wish you every success.</div>
          </div>
        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>

<!--TESTIMONIALS-->
<section class="s-testimonials-main ms-section">
  <div class="s-testimonials-main__head">
    <div class="section-bg"><img src="<?php echo get_template_directory_uri();?>/assets/images/bg-04.png" loading="lazy" alt=""></div>
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
              <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake caliper painting in Leeds</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim sit aliqua dolor do amet sint. Velit officia consequat duis enim sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake caliper painting in Leeds</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake caliper painting in Leeds</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
            </div>
            <div class="name">Floyd Miles</div>
            <div class="title">Porsche 911 Brembo brake</div>
            <div class="text">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim.</div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="item">
            <div class="top-line">
              <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/img-02.jpg" loading="lazy" alt=""></div>
              <div class="ratting"><img src="<?php echo get_template_directory_uri();?>/assets/images/icons/stars.svg" loading="lazy" alt=""></div>
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
        <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/logo-trustpilot.png" loading="lazy" alt=""></div>
        <div class="text"><span>4.9</span> (294 reviews)</div>
      </div>
      <div class="item">
        <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/logo-google.png" loading="lazy" alt=""></div>
        <div class="text"><span>4.4</span> (265 reviews)</div>
      </div>
      <div class="item">
        <div class="img"><img src="<?php echo get_template_directory_uri();?>/assets/images/logo-facebook.png" loading="lazy" alt=""></div>
        <div class="text"><span>50.000</span> followers</div>
      </div>
    </div>
  </div>
</section>

<!--KNOWLEDGE variant 3-->
<section class="s-knowledge s-knowledge--variant-3 ms-section">
  <div class="cn">
<!--    <div class="section-heading section-heading--simple">-->
<!--      <h2 class="title h1">FAQs</h2>-->
<!--      <div class="subtitle">Find answers to frequently asked questions about brake caliper refurbishment for this model.</div>-->
<!--    </div>-->
<!--    <div class="acc">-->
<!--      <div class="acc-item">-->
<!--        <div class="acc-head">How long does it take?</div>-->
<!--        <div class="acc-body">-->
<!--          <div class="inner">-->
<!--            <div class="text">The cost of brake caliper refurbishment for this model may vary based on the specific requirements and the condition of the calipers. Please contact us for a personalized estimate.</div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="acc-item">-->
<!--        <div class="acc-head">What is the cost?</div>-->
<!--        <div class="acc-body">-->
<!--          <div class="inner">-->
<!--            <div class="text">The cost of brake caliper refurbishment for this model may vary based on the specific requirements and the condition of the calipers. Please contact us for a personalized estimate.</div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="acc-item">-->
<!--        <div class="acc-head">Do you offer warranty?</div>-->
<!--        <div class="acc-body">-->
<!--          <div class="inner">-->
<!--            <div class="text">The cost of brake caliper refurbishment for this model may vary based on the specific requirements and the condition of the calipers. Please contact us for a personalized estimate.</div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="acc-item">-->
<!--        <div class="acc-head">Can I ship internationally?</div>-->
<!--        <div class="acc-body">-->
<!--          <div class="inner">-->
<!--            <div class="text">The cost of brake caliper refurbishment for this model may vary based on the specific requirements and the condition of the calipers. Please contact us for a personalized estimate.</div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--      <div class="acc-item">-->
<!--        <div class="acc-head">How do I order?</div>-->
<!--        <div class="acc-body">-->
<!--          <div class="inner">-->
<!--            <div class="text">The cost of brake caliper refurbishment for this model may vary based on the specific requirements and the condition of the calipers. Please contact us for a personalized estimate.</div>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
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
<section class="ms-section">
  <div class="cn">
    <?php the_content(); ?>
  </div>
</section>

<?php get_footer(); ?>
