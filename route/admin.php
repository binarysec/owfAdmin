<?php

class wfr_admin_admin extends wf_route_request {
	public function __construct($wf) {
		$this->wf = $wf;
	}

	public function show() {
		/*$this->wf->admin_html()->set_backlink(
			$this->wf->linker("/session/logout"),
			"Logout",
			"delete",
			true
		);*/
		
		$tpl = new core_tpl($this->wf);
		$this->wf->admin_html()->renderlinks(array(
			"body" => $tpl->fetch('admin/index'),
			"backurl" => "foo",
		));
	}
}