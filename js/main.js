
(function($){
	$('.item-content').on('click', 'a', function(e){
		if($(this).has('img'))
			e.preventDefault();
	});

	if( $(window).height() > $('body').height() ) {

		var h = $(window).height() - $('header').outerHeight() - $('footer').outerHeight();
		$('.main').css('min-height', h);			
	};

	$('.single-page, .page').find('img').each(function(i,e){
		$(e).removeAttr('height').removeAttr('width').addClass('img-responsive');
	})
})(jQuery)