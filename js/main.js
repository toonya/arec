
(function($){
	$('.item-content').on('click', 'a', function(e){
		if($(this).has('img'))
			e.preventDefault();
	})
})(jQuery)