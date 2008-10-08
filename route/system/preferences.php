<?php

class wfr_admin_system_preferences extends wf_route_request {

	private $a_core_route;
	private $a_admin_html;

	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_admin_html = $this->wf->admin_html();
	}

	public function show() {

		$tpl = new core_tpl($this->wf);
		
		$this->a_admin_html->set_title("Gestionnaire des préférences");
		$this->a_admin_html->set_subtitle("Gestionnaire des préférences: Liste des groupes");
		
		
		$this->a_admin_html->rendering($tpl->fetch('admin/system/preferences/list_group'));
		exit(0);
	}
	
}

