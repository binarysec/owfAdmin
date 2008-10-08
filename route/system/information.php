<?php

class wfr_admin_system_information extends wf_route_request {

	private $a_core_route;
	private $a_admin_html;

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

		$in = array(
			"version" => WF_VERSION,
			"os" => php_uname("s")." (".php_uname("r").")",
			"machine" => php_uname("m"),
			"php" => phpversion(),
			"zend" => zend_version(),
			"db" => $this->wf->db->get_driver_banner(),
			"cache" => $this->wf->core_cacher()->get_banner(),
			"server" => $server,
			"modules" => &$this->wf->modules
		);
		$tpl->set_vars($in);
		
// 		foreach($this->wf->modules as $k => $v) {
// 			$file = &$v[0];
// 			$name = &$v[1];
// 			$description = &$v[3]; 
// 			$banner = &$v[4];
// 			echo ">$v[5]<br>";
// 		}
		
		$this->a_admin_html->rendering($tpl->fetch('admin/system/information'));
		exit(0);
	}
	
}

