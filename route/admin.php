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

		$this->a_admin_html->set_help_title('Bienvenue&nbsp;!');
		$this->a_admin_html->set_help_text(
			'Bienvenue dans l\'interface d\'administration Web de BinarySec&nbsp;!
			 Les modules d\'administration du menu de gauche vous permettrons d\'administrer votre site Web.'
		);
		$this->a_admin_html->set_page_hint(
			'Quelques informations et statistiques sur
			 l\'utilisation de la base de donn&eacute;es.'
		);
		//$this->a_admin_html->set_sidebar_ext($this->a_admin_html->render_routes_tree());

		$tpl = new core_tpl($this->wf);
		$this->a_admin_html->rendering($tpl->fetch('admin/index'));
	}
	
}
