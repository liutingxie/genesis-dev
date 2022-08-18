jQuery(document).ready(function($) {

	// init Isotope
	function init() {
		$('.portfolio-content').isotope( {
			itemSelector: ".portfolio-item",
			masonry: {
				columnWidth:  ".portfolio-item",
				gutter: 30,
			}
		} );
	}

	init();

	// bind filter button click
	$('.filter-button-group').on('click', '.button', function() {
		$(this).siblings().css('transition-delay', '0s');
		var filterValue = $(this).attr('data-filter');
		// use filterFn if matches value
		$('.portfolio-content').isotope({
			filter: filterValue
		});

		$(this).parent().find(".button").removeClass("active"), $(this).addClass("active");

	});

	$.browser.msie && 8 == + $.browser.version ? document.body.onresize = function() {
		init();
	} : $(window).resize( function() {
		init();
	}), window.addEventListener( "orientationchange", function() {
		init();
	});
});