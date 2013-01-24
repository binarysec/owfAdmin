var	owf_display_msg_interval,
	owf_display_msg_seed,
	owf_display_msg_running = false,
	owf_display_msg_ticks = 0;

function owf_admin_display_msg_periodic() {
	owf_display_msg_ticks = owf_display_msg_ticks - 1;
	if(owf_display_msg_ticks <= 0) {
		$('#owf-admin-infobar-'+owf_display_msg_seed).html('').slideUp('normal');
		clearInterval(owf_display_msg_interval);
		owf_display_msg_running = false;
	}
}
	
function owf_admin_display_msg(seed, text, seconds) {
	$('#owf-admin-infobar-'+seed).html(text);
	owf_display_msg_ticks = seconds ? seconds : 2;
	owf_display_msg_seed = seed;
	if(!owf_display_msg_running) {
		$('#owf-admin-infobar-'+seed).slideDown('slow');
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
