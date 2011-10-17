<?php

class wfr_admin_system_system extends wf_route_request {
	public function __construct($wf) {
		$this->wf = $wf;
	}

	public function show() {
		$this->wf->admin_html()->set_title('Informations système');

		$tpl = new core_tpl($this->wf);
		$tpl->set('nb_users', $this->wf->session()->user_count());
		$tpl->set('nb_pref_groups', count($this->wf->core_pref()->group_find()));
		$tpl->set('perm_manage_users', $this->wf->session()->check_permission("session:manage"));
		$this->wf->admin_html()->rendering($tpl->fetch('admin/system/index'));
	}
}