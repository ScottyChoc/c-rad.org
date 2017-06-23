jQuery( document ).ready( function( $ ) {
	$('.front-page-slider').slick({
	dots: false,
	infinite: true,
	speed: 500,
	fade: true,
	cssEase: 'linear',
	autoplay: true,
	autoplaySpeed: 5000,
	adaptiveHeight: true,
	prevArrow: false,
	nextArrow: false
	});
});