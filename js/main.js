
(function($){
	$('.item-content').on('click', 'a', function(e){
		if($(this).has('img'))
			e.preventDefault();
	});

	if( $(window).height() > $('body').height() ) {
		console.log($(window).height() +' '+ $('body').height());
		$('body').addClass('fix-footer');
	};

	$('.single-page').find('img').each(function(i,e){
		$(e).removeAttr('height').removeAttr('width').addClass('img-responsive');
	})
})(jQuery)