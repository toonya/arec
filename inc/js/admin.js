jQuery(function($){
    // ----------------------------------------
    // ! modify options on user page
    // ----------------------------------------

    jQuery('#createuser').find('[for="url"]').closest('.form-field').hide();
    jQuery('#your-profile').find('.form-table').first().hide();
    jQuery('[name="admin_bar_front"]').attr('checked','checked');
    jQuery('[for="url"]').closest('tr').hide();

})


