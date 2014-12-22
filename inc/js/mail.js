// ----------------------------------------
// ! Handle ajax mail
// ----------------------------------------

(function($){

	"use strict"

	// ----------------------------------------
	// ! add some feature
	// ----------------------------------------
	$('form').each(function(){
		$('<input type="hidden">').attr('name','ajax_mail_type').val(mail_options.ajax_mail_type).prependTo($(this));
		$('<input type="hidden">').attr('name','security').val(mail_options.security).prependTo($(this));
		$('<input type="hidden">').attr('name','action').val(mail_options.action).prependTo($(this));
	})

	// ----------------------------------------
	// ! submit
	// ----------------------------------------

	$('form').on('submit',function(e){
		// disable submit event. use ajax instead;
		e.preventDefault();

		// form values to json object;
		var data = {};
		$.each($(this).serializeArray(), function(i,e){
			data[this.name] = this.value;
		})

		// extend the mail options with form data
		data = $.extend({}, data);

		// begin mailing
		//$('body').addClass('mailing');
		$('.mail-state [data-sending]').removeClass('hide');

		// post to server

		$.ajax({
			url : mail_options.ajax_url,
			type : 'post',
			data : new FormData( this ),
			processData : false,
			contentType : false,
			//dataType : 'json',
			success : function(mail){

				console.log(mail);

				// success
				if(mail.state) {
					$('form')[0].reset();

					$('.mail-state').children().addClass('hide');

					$('.mail-state [data-done]').removeClass('hide');

					setTimeout(function(){
						$('.mail-state [data-done]').addClass('hide');
					}, 1000);
				}

				//fail
				else {
					$('.mail-state').children().addClass('hide');

					$('.mail-state [data-error]').removeClass('hide');

					setTimeout(function(){
						$('.mail-state [data-error]').addClass('hide');
					}, 1000);

					console.log(data);
					console.log(mail_options);
				}

			}
		}).fail(function(){
			$('.mail-state').children().addClass('hide');

			$('.mail-state [data-error]').removeClass('hide');

			setTimeout(function(){
				$('.mail-state [data-error]').addClass('hide');
			}, 1000);
			
			console.log(data);
			console.log(mail_options);
		});

	});

	// ----------------------------------------
	// ! show result
	// ----------------------------------------
	$('.mailinfo .close').on('click', 'span', function(){
		$('body').removeClass('mailing');

		$('.mailinfo .success, .mailinfo .fail').addClass('hide');
		$('.mailinfo .sending').removeClass('hide');
	})


})(jQuery)