<?php

class wfr_admin_system_system extends wf_route_request {

	public function __construct($wf) {
		$this->wf = $wf;
	}

	public function show() {
		$this->wf->admin_html()->set_subtitle('Informations système');

		$tpl = new core_tpl($this->wf);
		$tpl->set('nb_users', count($this->wf->core_session()->user_list()));
		$tpl->set('nb_pref_groups', count($this->wf->core_pref()->group_find()));
		$this->wf->admin_html()->rendering($tpl->fetch('admin/system/index'));
	}
	
}
