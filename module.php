<?php

class wfm_admin extends wf_module {
	public function __construct($wf) {
		$this->wf = $wf;
	}
	
	public function get_name() { return("admin"); }
	public function get_description()  { return("OWF Native Administration module"); }
	public function get_banner()  { return("admin/1.4.0"); }
	public function get_version() { return("1.4.0"); }
	public function get_authors() { return(array("Michael VERGOZ")); }
	public function get_depends() { return(NULL); }
	
	public function session_permissions() {
		return(array(
			"admin" => $this->ts("Allow access to administration"),
			"admin:system" => $this->ts("Allow access to system view"),
			"admin:system:preferences" => $this->ts("Allow access to system preferences")
		));
	}
	
	public function get_actions() {
		return(array(
			"/admin" => array(
				WF_ROUTE_ACTION,
				"admin",
				"show",
				$this->ts("Administration"),
				WF_ROUTE_SHOW,
				array("admin"),
			),
			
			"/admin/options" => array(
				WF_ROUTE_ACTION,
				"admin/options",
				"show",
				$this->ts("Options"),
				WF_ROUTE_HIDE,
				array("admin"),
			),
			
			/* system management */
			"/admin/system" => array(
				WF_ROUTE_ACTION,
				"admin/system",
				"show",
				$this->ts("Préférences systèmes"),
				WF_ROUTE_SHOW,
				array("admin:system"),
// 				"/data/admin/img/menu_system.png"
			),
			"/admin/system/information" => array(
				WF_ROUTE_ACTION,
				"admin/system/information",
				"show",
				$this->ts("Informations système"),
				WF_ROUTE_SHOW,
				array("admin:system")
			),
			
// 			/* preference edition */
// 			"/admin/system/preferences" => array(
// 				WF_ROUTE_REDIRECT,
// 				"/admin/system/preferences/variables",
// 				$this->ts("Préférences système"),
// 				WF_ROUTE_SHOW,
// 				array("admin:system:preferences")
// 			),
// 			
// 			"/admin/system/preferences/variables" => array(
// 				WF_ROUTE_ACTION,
// 				"system/preferences",
// 				"show_groups",
// 				$this->ts("Préférences des variables"),
// 				WF_ROUTE_SHOW,
// 				array("admin:system:preferences")
// 			),
// 			"/admin/system/preferences/variables/edit" => array(
// 				WF_ROUTE_ACTION,
// 				"system/preferences",
// 				"edit_var",
// 				"Préférences système",
// 				WF_ROUTE_HIDE,
// 				array("admin:system:preferences")
// 			),

			
		));
	}

	public function get_index() {
		$tpl = new core_tpl($this->wf);
		$tpl->set('nb_users', count($this->wf->core_session()->user_list()));
		$tpl->set('nb_pref_groups', count($this->wf->core_pref()->group_find()));
		return($tpl->fetch('admin/system/index'));
	}
}
