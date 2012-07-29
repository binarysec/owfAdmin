<?php

class wfr_admin_admin_system extends wf_route_request {
	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_admin_html = $this->wf->admin_html();
	}

	public function show() {
		/* get primary content */
		$tpl = new core_tpl($this->wf);
		$in = array(			
		);	 
		$tpl->set_vars($in);
		$this->a_admin_html->set_backlink($this->wf->linker('/admin'));
		$this->a_admin_html->renderlinks(array(
			"body" => $tpl->fetch('admin/system/index'),
		));
	}
}