
(function($){
	$('.item-content').on('click', 'a', function(e){
		if($(this).has('img'))
			e.preventDefault();
	});

	if( $(window).height() > $('body').height() ) {
		if( $('body .tab-nav').size() > 0 ) {
			var h = 0;

			$('.tab-content .tab-pane').each(function(i,e){
				if( $(e).outerHeight() > h )
					h = $(e).outerHeight();
			})

			$('.tab-content').css('min-height', h);
		}

		if( $(window).height() > $('body').height() ) 
			$('body').addClass('fix-footer');			
	};

	$('.single-page').find('img').each(function(i,e){
		$(e).removeAttr('height').removeAttr('width').addClass('img-responsive');
	})
})(jQuery)