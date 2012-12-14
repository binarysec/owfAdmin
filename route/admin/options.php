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
		
		$this->lang = $this->wf->core_lang()->get_context(
			"admin/options"
		);
		
		/* change global template for options */
		$this->a_admin_html->template = 'admin/options/main';
		
		$this->uid = null;
	}
	
	public function show() {
		$this->uid = $this->wf->get_var("uid");
		$self_edition = false;
		
		if(!$this->uid) {
			$this->uid = $this->a_session->session_me["id"];
			$self_edition = true;
		}
		
		$r = $this->a_admin_html->check_options_policy($this->uid, $user);
		if(is_null($user))
			$this->wf->display_error(500, "", true);
		
		if(!$r)
			$this->wf->display_error(403, "", true);
		
		$perms = $this->a_session->perm->user_get($this->uid);
		
		$tpl = new core_tpl($this->wf);
		
		/* get back URL */
		$burl = $this->a_core_cipher->get_var("back");
		if(!$burl)
			$this->wf->display_error(500, "", true);
		
		/* rendering using my template */
		$theme = $this->a_core_cipher->get_var("theme");
		if(!$theme)
			$theme = "a";
			
		$this->a_admin_html->div_set("data-theme", $theme);
		
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
					if($theme)
						$aopt["link"] .= '&theme='.$this->a_core_cipher->encode($theme);
					array_push($this->aopts, $aopt);
				}
			}
		}
		
		$in = array(
			"aopts" => $this->aopts,
			"user" => $user,
			"perms" => $perms,
			"self_edition" => $self_edition,
			"langs" => $this->wf->core_lang()->get_list(),
			"iam_admin" => $this->a_session->iam_admin(),
			"activation_required" => isset($this->wf->ini_arr['session']['activation_required']) ?
			$this->wf->ini_arr['session']['activation_required'] : false
		);
	
		$tpl->set_vars($in);

		$this->a_admin_html->set_backlink($burl);
		$this->a_admin_html->set_title($this->lang->ts("User options"));
		$this->a_admin_html->rendering($tpl->fetch('admin/options/index'), true, false);
		exit(0);
	}
	
	public function edit() {
		
		/* get parameters */
		$field = $this->wf->get_var("f");
		$value = $this->wf->get_var("v");
		$uid = (int) $this->wf->get_var("u");
		$me = (int)$this->a_session->session_me["id"];
		
		/* check parameters */
		if(strlen($field) > 0 && strlen($value) > 0 && $uid > 0) {
			
			/* check which field is trying to be edited */
			if($field == "lang") {
				
				/* check lang registered */
				if($this->wf->core_lang()->resolv($value)) {
					
					/* if self edition or admin */
					if($uid == $me || $this->a_session->iam_admin()) {
						$this->a_session->user->modify(array("lang" => $value), $uid);
					}
				}
			}
			elseif($field == "activated" && $this->a_session->iam_admin()) {
				$this->a_session->user->modify(array("activated" => "true"), $uid);
				$this->wf->redirector($this->wf->linker('/admin/system/session'));
			}
			echo
				$this->wf->display_error(404, "Field not found");
		}
		$this->wf->display_error(404, "Page not found");
		
		exit(0);
	}
	
}
