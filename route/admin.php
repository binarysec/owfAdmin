<?php

class wfr_admin_admin extends wf_route_request {

	private $a_core_route;
	private $a_admin_html;

	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_core_route = $this->wf->core_route();
		$this->a_admin_html = $this->wf->admin_html();
	}

	public function show() {
		$html = '';

		/* menu global d'administration */
 		$routes = &$this->wf->core_route()->routes[0]["admin"][0];
 		foreach($routes as $route) {
			if($route[1][2] == WF_ROUTE_ACTION) {
				$mod = $this->wf->modules[$route[1][1]][8];
				if(method_exists($mod, 'get_index')) {
						$html .= '<h1>'.$route[1][5].'</h1>';
					$html .= $mod->get_index();
				}
			}
		}

		$this->a_admin_html->rendering($html);
	}

}
