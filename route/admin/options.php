<?php

class wfr_admin_admin_options extends wf_route_request {

	private $a_core_route;
	private $a_admin_html;
	private $aopts = array();
	
	public function __construct($wf) {
		$this->wf = $wf;
		$this->a_admin_html = $this->wf->admin_html();
		$this->a_core_cipher = $this->wf->core_cipher();
		$this->a_session = $this->wf->session();
		/* change global template for options */
// 		$this->a_admin_html->template = 'admin/options/main';

		$this->uid = null;
	}
	
	
	public function show() {
		$this->uid = $this->wf->get_var("uid");
		if(!$this->uid)
			$this->uid = $this->a_session->session_me["id"];
		
		$r = $this->a_admin_html->check_options_policy($this->uid, $user);
		if(!$r)
			exit(0);
		
		$perms = $this->a_session->perm->user_get($this->uid);
		
		$tpl = new core_tpl($this->wf);
		
		/* get back URL */
		$burl = $this->a_core_cipher->get_var("back");
		if(!$burl)
			exit(0);
		
		$here = $this->a_core_cipher->encode($_SERVER['REQUEST_URI']);
		$this->a_admin_html->set("backurl", $burl);
		
		/* get aopts */
		$ret = $this->wf->execute_hook("admin_options");
		foreach($ret as $aopts) {
			foreach($aopts as $aopt) {
				if($this->a_admin_html->check_permission($aopt["perm"])) {
					$aopt["link"] = $this->wf->linker($aopt["route"])."?back=$here";
					if($this->uid)
						$aopt["link"] .= '&uid='.$this->uid;
					array_push($this->aopts, $aopt);
				}
			}
		}
		
		$in = array(
			"backurl" => $burl,
			"aopts" => $this->aopts,
			"user" => $user,
			"perms" => $perms
		);
	
		$tpl->set_vars($in);
		
		/* rendering using my template */
		$this->a_admin_html->div_set("data-theme", "a");
		$this->a_admin_html->set_backlink($burl);
		$this->a_admin_html->rendering($tpl->fetch('admin/options/index'), true, false);
		exit(0);
	}
	
}

