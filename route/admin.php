<?php

class wfr_admin_admin extends wf_route_request {

	private $a_core_route;

	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_core_route = $this->wf->core_route();
	}

	public function show_admin() {
		$admin_html = $this->wf->admin_html();
		$admin_html->set_page_hint('Quelques informations et statistiques sur l\'utilisation de la base de donn&eacute;es.');
		$admin_html->set_help_title('Bienvenue&nbsp;!');
		$admin_html->set_help_text('Bienvenue dans l\'interface d\'administration Web de BinarySec&nbsp;!');

		$tpl = new core_tpl($this->wf);
		$admin_html->rendering($tpl->fetch('admin/index'));
	}
	
}
