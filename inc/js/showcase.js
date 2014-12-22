jQuery(function($){
	// ----------------------------------------
	// ! open-close edit area.
	// ----------------------------------------

	jQuery('.funtions').on('click.editOpen','.edit-close',function(e){
		e.preventDefault();

		jQuery(this).addClass('edit-open').removeClass('edit-close').text('完成');
		jQuery('.showcase .item:not(.template) .edit-area').removeClass('hidden');
	});
	jQuery('.funtions').on('click.editClose','.edit-open',function(e){
		e.preventDefault();
		
		jQuery(this).addClass('edit-close').removeClass('edit-open').text('编辑');
		jQuery('.showcase .item:not(.template) .edit-area').addClass('hidden');
	});

	/*
	 * make delete function
	 */

	jQuery('.showcase').on('click.deleteItem','.close',function(e){
		jQuery(this).closest('.item').remove();
		fresh_showcase();
	})

	/*
	 * fresh showcase item, make the name value strong.
	 */

	function fresh_showcase(){
		jQuery('.showcase .item:not(.template) input').each(function(i,e){
			new_name = jQuery(e).attr('id')+'['+i+']';
			jQuery(e).attr('name',new_name);
		})
	}


	/*
	 * two variable we need here.
	 */


	var showcase_uploader;
	var showcase_reciever;

	// Bind to our click event in order to open up the new media experience.
	$('#showcase .funtions .new').on('click.imgOpenMediaManager' ,function(e){ //ty-open-media is the class of our form button

		/*
		 * check whether the wp media manager is exist.
		 */


		if ( showcase_uploader ) {
			showcase_uploader.open();
			return;
		}

		/*
		* if not. init the wp media manager
		*/


		showcase_uploader = wp.media.frames.showcase_uploader = wp.media({

		 //createe our media frame

		 	multiple: true, //Disallow Mulitple selections

		});


		showcase_uploader.on('select', function(){
		// Grab our attachment selection and construct a JSON representation of the model.
			var media_attachment = showcase_uploader.state().get('selection').map( function( attachment ) {
											  attachment = attachment.toJSON();
											  return attachment;
											  });

		//the current quantity of item
		count  = jQuery('#showcase .item').not('.template').size();


		/*
		 * handle the data.
		 */


		$.each(media_attachment,function(i,$img){

			$img = $img.url;

			reg = /\.[a-zA-Z]*\b/g;

			/*
			 * match items to array
			 */

			match_list = $img.match(reg);

			/*
			 * get the laset match item
			 */


			the_last   = match_list[match_list.length-1];
			the_value  = '-150x150'+the_last;

			// final item.
			$img = $img.replace(the_last, the_value);

			/*
			 * make the name value
			 */

			/*
			 * the media info. reciever
			 */

			showcase_reciever = jQuery('#showcase .template').clone();

			// because the count is begin from 1, and the [] from 0, so doesn't need to add 1.
			name   = showcase_reciever.find('input').attr('id')+'['+count+']';

			/*
			 * make the new item
			 */

			showcase_reciever.removeClass('hidden').removeClass('template')
			.find('input').val($img).attr('name',name)
			.parent().find('img').attr('src',$img);

			jQuery('.showcase').append(showcase_reciever);

			count = count+1;

		})


		});


		/*
		 * first time open.
		 */


		showcase_uploader.open();
	});
})