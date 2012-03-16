function checkColors() {
	var enable = $('#enable_colors').val();
	
	if(enable != 'yes') {
		$('#colorpicker_container').hide();
	} else {
		$('#colorpicker_container').show();
	}
}

function checkBackground() {
	var enable = $('#enable_background').val();

	if(enable != 'yes') {
		$('#background_container').hide();
	} else {
		$('#background_container').show();
	}
}

$(document).ready(function() {
	checkColors();
	checkBackground();
	
	$('#backgroundpicker').farbtastic('#backgroundcolor');
	$('#borderpicker').farbtastic('#bordercolor');
	$('#titlepicker').farbtastic('#titlecolor');
});