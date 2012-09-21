var	owf_display_msg_interval,
	owf_display_msg_running = false,
	owf_display_msg_ticks = 0;

function owf_admin_display_msg_periodic() {
	owf_display_msg_ticks = owf_display_msg_ticks - 1;
	if(owf_display_msg_ticks <= 0) {
		$('#owf-admin-infobar').html('').slideUp('normal');
		clearInterval(owf_display_msg_interval);
		owf_display_msg_running = false;
	}
}
	
function owf_admin_display_msg(text) {
	$('#owf-admin-infobar').html(text);
	
	owf_display_msg_ticks = 2;
	if(!owf_display_msg_running) {
		$('#owf-admin-infobar').slideDown('slow');
		owf_display_msg_running = true;
		owf_display_msg_interval = setInterval("owf_admin_display_msg_periodic()", 1000);
	}
}

function owf_admin_confirm_deletion(href) {
	$('<div>').simpledialog2({
		mode: 'blank',
		headerText: 'Delete confirmation',
		headerClose: true,
		dialogAllow: true,
		dialogForce: false,
		width: "400px",
		height: "300px",
		blankContent :
			'<p><center style="padding: 10px;"><form action="' + href + '">' +
				'Are you sure about deleting this ?<br/>' +
				'<fieldset class="ui-grid-a">' +
					'<div class="ui-block-a"><input type="submit" data-role="button" value="Delete" /></div>' +
					'<div class="ui-block-b"><a rel="close" data-role="button" href="#">Close</a></div>' +
				'</fieldset>' +
			'</form></center></p>'
	});
	return false;
}