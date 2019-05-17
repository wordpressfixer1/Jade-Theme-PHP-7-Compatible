/* global confirm, redux, redux_change */

jQuery(document).ready(function() {
    jQuery('.mmm_mfp').magnificPopup({
        modal: true,
        type: 'inline',
        preloader: false,
        midClick: true,
    });


    jQuery( document ).on('click','.met_fa_trigger_button',function(){
        var $this = jQuery(this);
        var $id 	= $this.attr('rel');

        jQuery('.met_fa_rel').val($id);
    });

    jQuery( document ).on('click','#met_mfp_fa_icon_list .button',function(){
        var $this = jQuery(this);
        var $id 	= jQuery('.met_fa_rel').val();
        var $icon 	= $this.data('icon');

        jQuery('#met-fa-input-'+$id).val($icon);
        jQuery('.met-fa-wrap-'+$id+' > span.add-on > i').removeClass();
        jQuery('.met-fa-wrap-'+$id+' > span.add-on > i').addClass('fa').addClass($icon);

        jQuery('.met_fa_rel').val('');
        jQuery.magnificPopup.close();
    });

    jQuery( document ).on('click','.met_fa_clear_button',function(){
        var $this = jQuery(this);
        var $id 	= $this.attr('rel');

        jQuery('#met-fa-input-'+$id).val('');
        jQuery('.met-fa-wrap-'+$id+' > span.add-on > i').removeClass();
        jQuery('.met-fa-wrap-'+$id+' > span.add-on > i').addClass('fa').addClass('fa-times fa-none');

    });



    jQuery( document ).on('click', '.met_mfp_fa_cancel',
        function(){
            jQuery('.met_fa_rel').val('');
            jQuery.magnificPopup.close();
        }
    );

});
