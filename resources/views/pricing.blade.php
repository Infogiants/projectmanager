@extends('layouts.app')

@section('title', 'Home')

@section('content')


<main id="main">

    <!-- ======= FeatPricingures Section ======= -->
    <div class="hero-section inner-page">
      <div class="wave">

        <svg width="1920px" height="265px" viewBox="0 0 1920 265" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
              <path d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,667 L1017.15166,667 L0,667 L0,439.134243 Z" id="Path"></path>
            </g>
          </g>
        </svg>

      </div>

      <div class="container">
        <div class="row align-items-center">
          <div class="col-12">
            <div class="row justify-content-center">
              <div class="col-md-7 text-center hero-text">
                <h1 data-aos="fade-up" data-aos-delay="">Our Pricing</h1>
                <p class="mb-5" data-aos="fade-up" data-aos-delay="100">From individual and small business, we have a plan for you.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <section class="section">
      <div class="container">

        <div class="row justify-content-center text-center">
          <div class="col-md-7 mb-5">
            <!-- <h2 class="section-heading">Our Plans</h2> -->
            <p>On Registration you will have Free plan activated by default, After Login you can upgrade plan any time from dashboard.</p>
          </div>
        </div>
        <div class="row align-items-stretch">

          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="pricing h-100 text-center">
              <span>&nbsp;</span>
              <h3>Basic</h3>
              <ul class="list-unstyled">
                <li>Create up to 5 projects</li>
                <li>Generate 5 monthly reports</li>
                <li>Add up to 5 clients</li>
              </ul>
              <div class="price-cta">
                <strong class="price">Free</strong>
                <!-- <p><a href="#" class="btn btn-white">Choose Plan</a></p> -->
              </div>
            </div>
          </div>
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="pricing h-100 text-center popular">
              <span class="popularity">Most Popular</span>
              <h3>Professional</h3>
              <ul class="list-unstyled">
                <li>Create up to 20 projects</li>
                <li>Generate 20 monthly reports</li>
                <li>Add up to 20 clients</li>
              </ul>
              <div class="price-cta">
                <strong class="price">$1/month</strong>
                <!-- <p><a href="#" class="btn btn-white">Choose Plan</a></p> -->
              </div>
            </div>
          </div>
          <div class="col-lg-4 mb-4 mb-lg-0">
            <div class="pricing h-100 text-center">
              <span class="popularity">Best Value</span>
              <h3>Ultimate</h3>
              <ul class="list-unstyled">
                <li>Create up to 100 projects</li>
                <li>Generate 100 monthly reports</li>
                <li>Add up to 100 clients</li>
              </ul>
              <div class="price-cta">
                <strong class="price">$5/month</strong>
                <!-- <p><a href="#" class="btn btn-white">Choose Plan</a></p> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ======= Testimonials Section ======= -->
    <section class="section border-top border-bottom">
      <div class="container">
        <div class="row justify-content-center text-center mb-5">
          <div class="col-md-4">
            <h2 class="section-heading">Review From Our Users</h2>
          </div>
        </div>
        <div class="row justify-content-center text-center">
          <div class="col-md-7">
            <div class="owl-carousel testimonial-carousel">
              <div class="review text-center">
                <p class="stars">
                  <span class="icofont-star"></span>
                  <span class="icofont-star"></span>
                  <span class="icofont-star"></span>
                  <span class="icofont-star"></span>
                  <span class="icofont-star muted"></span>
                </p>
                <h3>Excellent App!</h3>
                <blockquote>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus pariatur, numquam
                    aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae deleniti minus animi,
                    provident voluptates consectetur maiores quos.</p>
                </blockquote>

                <p class="review-user">
                  <img src="assets/img/person_1.jpg" alt="Image" class="img-fluid rounded-circle mb-3">
                  <span class="d-block">
                    <span class="text-black">Jean Doe</span>, &mdash; App User
                  </span>
                </p>

              </div>

              <div class="review text-center">
                <p class="stars">
                  <span class="icofont-star"></span>
                  <span class="icofont-star"></span>
                  <span class="icofont-star"></span>
                  <span class="icofont-star"></span>
                  <span class="icofont-star muted"></span>
                </p>
                <h3>This App is easy to use!</h3>
                <blockquote>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus pariatur, numquam
                    aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae deleniti minus animi,
                    provident voluptates consectetur maiores quos.</p>
                </blockquote>

                <p class="review-user">
                  <img src="assets/img/person_2.jpg" alt="Image" class="img-fluid rounded-circle mb-3">
                  <span class="d-block">
                    <span class="text-black">Johan Smith</span>, &mdash; App User
                  </span>
                </p>

              </div>

              <div class="review text-center">
                <p class="stars">
                  <span class="icofont-star"></span>
                  <span class="icofont-star"></span>
                  <span class="icofont-star"></span>
                  <span class="icofont-star"></span>
                  <span class="icofont-star muted"></span>
                </p>
                <h3>Awesome functionality!</h3>
                <blockquote>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius ea delectus pariatur, numquam
                    aperiam dolore nam optio dolorem facilis itaque voluptatum recusandae deleniti minus animi,
                    provident voluptates consectetur maiores quos.</p>
                </blockquote>

                <p class="review-user">
                  <img src="assets/img/person_3.jpg" alt="Image" class="img-fluid rounded-circle mb-3">
                  <span class="d-block">
                    <span class="text-black">Jean Thunberg</span>, &mdash; App User
                  </span>
                </p>

              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= CTA Section ======= -->
    <section class="section cta-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 mr-auto text-center text-md-left mb-5 mb-md-0">
                        <h2>Start Managing projects</h2>
                    </div>
                    <div class="col-md-5 text-center text-md-right" data-aos="fade-left" data-aos-delay="200" data-aos-offset="-500">
                        <a href="{{ route('login') }}" class="btn">Get Access</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End CTA Section -->

  </main><!-- End #main -->
@endsection