<?php

class wfr_admin_admin extends wf_route_request {

	public function __construct($wf) {
		$this->wf = $wf;

	}

	public function show_admin() {
		$core_admin = $this->wf->admin_html();

		$core_admin->rendering('');
	}
	
}
