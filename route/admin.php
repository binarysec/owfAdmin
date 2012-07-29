<?php

class wfr_admin_admin extends wf_route_request {
	public function __construct($wf) {
		$this->wf = $wf;
	}

	public function show() {
		$this->wf->admin_html()->renderlinks();
	}
}