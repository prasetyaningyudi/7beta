$(document).ready(function() {
	$('.nav-trigger').click(function() {
		$('.side-nav').toggleClass('visible');
	});
	
	$('a.button-login').click(function(e) {
		$(".login-sec").delay(100).fadeIn(100);
 		$(".register-sec").fadeOut(100);
		$('a.button-register').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
	$('a.button-register').click(function(e) {
		$(".register-sec").delay(100).fadeIn(100);
 		$(".login-sec").fadeOut(100);
		$('a.button-login').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});	
});