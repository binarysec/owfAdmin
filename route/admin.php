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
		//$base = $this->a_core_request->get_ghost();
		//$tree = $this->a_cms_categories->render_tree($base);

		$this->a_admin_html->set_subtitle('Partie administration !');
	

		$tpl = new core_tpl($this->wf);
		$this->a_admin_html->rendering($tpl->fetch('admin/index'));
	}
	
}
