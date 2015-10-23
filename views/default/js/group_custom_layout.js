define(['require', 'jquery', 'thickbox_js', 'farbtastic_js'], function(require, $, t, f) {

    if ($('#editForm').length) {

        if ($('#enable_colors').val() != 'yes') {
            $('#colorpicker_container').hide();
        } else {
            $('#colorpicker_container').show();
        }



        if ($('#enable_background').val() != 'yes') {
            $('#background_container').hide();
        } else {
            $('#background_container').show();
        }


        $('#backgroundpicker').farbtastic('#backgroundcolor');
        $('#borderpicker').farbtastic('#bordercolor');
        $('#titlepicker').farbtastic('#titlecolor');
    }

});