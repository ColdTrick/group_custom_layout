define(['require', 'jquery', 'thickbox_js', 'farbtastic_js'], function(require, $, t, f) {

    if ($('#editForm').length) {

        $(document).on('change', '#enable_colors', function() {
            if ($('#enable_colors').val() != 'yes') {
                $('#colorpicker_container').hide();
            } else {
                $('#colorpicker_container').show();
            }
        });


        $(document).on('change', '#enable_background', function() {
            if ($('#enable_background').val() != 'yes') {
                $('#background_container').hide();
            } else {
                $('#background_container').show();
            }
        });


        $('#backgroundpicker').farbtastic('#backgroundcolor');
        $('#borderpicker').farbtastic('#bordercolor');
        $('#titlepicker').farbtastic('#titlecolor');
    }

});