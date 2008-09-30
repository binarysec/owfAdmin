<?php

class wfr_admin_sys_informations extends wf_route_request {

	private $a_core_route;
	private $a_admin_html;

	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_admin_html = $this->wf->admin_html();
	}

	public function show() {

		$tpl = new core_tpl($this->wf);

		$in = array(
			"version" => WF_VERSION,
			"os" => php_uname("s"),
			"machine" => php_uname("m"),
			"php" => phpversion(),
			"zend" => zend_version(),
			"db" => $this->wf->db->get_driver_banner(),
			"cache" => $this->wf->core_cacher()->get_banner()
		);
		$tpl->set_vars($in);
		
		$this->a_admin_html->rendering($tpl->fetch('admin/sys/informations'));
		echo 'caco';
		exit(0);
	}
	
}

