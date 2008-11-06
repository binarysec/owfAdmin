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
			$mod = $route[1][1];
			if($mod == 'admin')
				$index_tpl = '/admin/system/index';
			else
				$index_tpl = $mod.'/admin/index';

			$tpl = new core_tpl($this->wf);
			if($tpl->locate($index_tpl)) {
				$name = $route[1][2] == WF_ROUTE_ACTION ? $route[1][5] : $route[1][4];
				$html .= '<h1>'.$name.'</h1>';
				$html .= $tpl->fetch($index_tpl);
			}
		}

		$this->a_admin_html->rendering($html);
	}

}
