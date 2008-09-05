<?php

class wfr_admin_admin extends wf_route_request {

	private $a_core_route;

	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_core_route = $this->wf->core_route();

		//$this->get_subroutes('/admin')
	}

	public function show_admin() {
		$core_admin = $this->wf->admin_html();
		$core_admin->set_title('Panneau d\'administration');
		$core_admin->rendering('');
	}
	
}
