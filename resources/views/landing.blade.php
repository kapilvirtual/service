@extends('layouts.header')
    <section class="container-fluid banner-view">
	<div class="row">
		<div class="banner-content">
			<h1>The Most Powerful <span>Business Crm</span></h1>
			<p>Kickstart The Assessment And Enterprises To Scale Their Process</p>
		</div>
		<!-- arrow down -->	
	</div>
</section>
<!-- Entire Service Section -->
<section class="container-fluid entire-service">
	<div class="row">
	<h3>Analyze tyour Entire service</h3>		
		<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 service-tab">
			<img src="{{ asset('images/customizable-icon.png') }}" alt="customizable"/>
			<h5>Highly Customizable</h5>
			<p>When you’re ready to start your risk assessment, all the data gathering has been automated for you. Our platform empowers the vendor to gather information and showcase their security posture over time.</p>		
		</div>		
		<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 service-tab">
			<img src="{{ asset('images/fast-support-icon.png') }}" alt="fast-support"/>
			<h5>Fast Support</h5>
			<p>When you’re ready to start your risk assessment, all the data gathering has been automated for you. Our platform empowers the vendor to gather information and showcase their security posture over time.</p>		
		</div>		
		<div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 service-tab">
			<img src="{{ asset('images/compatiblity-icon.png') }}" alt="compatiblity"/>
			<h5>Compatiblity</h5>
			<p>When you’re ready to start your risk assessment, all the data gathering has been automated for you. Our platform empowers the vendor to gather information and showcase their security posture over time.</p>		
		</div>		
	</div>
</section>
<!-- Mid Sign Up Section -->
<section class="container-fluid sign-up-section">		
	<div class="row">		
		<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 col-lg-push-1 admin-img">
			<img src="{{ asset('images/admin-img.png') }}" alt="" class="img-responsive" />
		</div>
		<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 col-lg-push-1 sign-up-content">
			<h3>Probably the best multipurpose Crm</h3>
			<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled</p>
			<a href="#" class="signup-btn">Sign Up</a> 
		</div>		
	</div>
</section>
<svg id="bigTriangleColor" width="100%" height="100" viewBox="0 0 100 102" preserveAspectRatio="none">
    <path d="M0 0 L50 100 L100 0 Z"></path>
</svg>
<!-- Testimonial Section -->
<section class="container-fluid testimonial-section">
	<div class="row">
		<div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 col-lg-push-1 testimonial-title">
			<h3>testimonial</h3>
			<p>Lorem Ipsum has been the industry's standard dummy text ever since the1500s, when an unknown printer took a galley of type and scrambled</p>
		</div>	
		<div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 col-lg-push-1 testimonials-details">
		<!-- slider Testimonials -->				
		<div class="slider-wrapper">
		  <div class="slider-activation">
			<div class="slider-contents">
			  <div class="slider-comment">
				<div class="triangle"></div>
				<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
			  </div>
			  <div class="slider-commentor">
				<img src="{{ asset('images/pic.png') }}" alt="">
				<div class="commentor-details">
				  <h3>- John Doe</h3>
				  <h4>Manager</h4>
				</div>
			  </div>
			</div>
			<div class="slider-contents">
			  <div class="slider-comment">
				<div class="triangle"></div>
				<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries</p>
			  </div>
			  <div class="slider-commentor">
				<img src="{{ asset('images/pic.png') }}" alt="">
				<div class="commentor-details">
				  <h3>- Lara Jon</h3>
				  <h4>Director</h4>
				</div>
			  </div>
			</div>
			<div class="slider-contents">
			  <div class="slider-comment">
				<div class="triangle"></div>
				<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Qui, doloribus?</p>
			  </div>
			  <div class="slider-commentor">
				<img src="{{ asset('images/pic.png') }}" alt="">
				<div class="commentor-details">
				  <h3>- John Doe2</h3>
				  <h4>oraganization</h4>
				</div>
			  </div>
			</div>
		  </div>
		</div>
		<!-- slider Testimonials End -->
		</div>
	</div>
</section>
@include('layouts.footer')
@include('partials.landingscripts')
<script>
jQuery(document).ready(function(){
	jQuery('.slider-activation').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1
	});
})
if ($('#back-to-top').length) {
    var scrollTrigger = 150, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 700);
    });
}
</script>
</body>
</html>