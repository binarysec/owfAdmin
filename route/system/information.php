<?php

class wfr_admin_system_information extends wf_route_request {

	private $a_core_route;
	private $a_admin_html;
	private $partners = array();
	
	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_admin_html = $this->wf->admin_html();
	}
	
	
	public function show() {

		$tpl = new core_tpl($this->wf);

		if(function_exists("apache_get_version"))
			$server = apache_get_version();
		else
			$server = $_SERVER["SERVER_SOFTWARE"];


		/* get partners */
		$ret = $this->wf->execute_hook("admin_partners");
		foreach($ret as $partners) {
			foreach($partners as $partner) {
				if(array_key_exists("img", $partner))
					$partner["img"] = $this->wf->linker($partner["img"]);
				array_push($this->partners, $partner);
			}
		}
		
		$in = array(
			"version" => WF_VERSION,
			"os" => php_uname("s")." (".php_uname("r").")",
			"machine" => php_uname("m"),
			"php" => phpversion(),
			"zend" => zend_version(),
			"db" => $this->wf->db->get_driver_banner(),
			"cache" => $this->wf->core_cacher()->get_banner(),
			"server" => $server,
			"modules" => &$this->wf->modules,
			"partners" => &$this->partners,
			"partners_c" => count($this->partners),
		);
	
		$tpl->set_vars($in);

		$this->a_admin_html->rendering($tpl->fetch('admin/system/information'));
		exit(0);
	}
	
}

