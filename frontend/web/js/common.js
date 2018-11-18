$('#my-menu').mmenu({
    extensions: [ 'widescreen', 'theme-black', 'effect-menu-slide', 'pagedim-black' ],
    navbar: {
        title: '<img src="/images/logo.png" alt="Xenos">'
    },
    offCanvas: {
        position  : 'right'
    }
});
var api = $('#my-menu').data('mmenu');
	api.bind('opened', function () {
		$('.hamburger').addClass('is-active');
	}).bind('closed', function () {
		$('.hamburger').removeClass('is-active');
    });


$(window).on('load', function() {
    $('.preloader__wrapper').delay(1000).fadeOut('slow');
});

// removes standard Navbar Widget classes
$('#w0').removeClass('nav');
$('.mm-listview').removeClass('nav');
// $('nav').removeClass('navbar');

$('.active > a').addClass('active');
$('.navbar__list__item').removeClass('active');