<?php

class wfr_admin_admin extends wf_route_request {

	private $a_core_route;

	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_core_route = $this->wf->core_route();

		echo '<pre>';

		
		$this->nav('', &$this->a_core_route->routes[0]);
print_r(&$this->a_core_route->routes[0]);
		

		exit(0);
	}

	private function nav($base, $routes, $l=0) {
		foreach($routes as $i => $route) {
			//
		}
	}

	public function show_admin() {
		$core_admin = $this->wf->admin_html();

		$core_admin->rendering('');
	}
	
}
