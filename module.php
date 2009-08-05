<?php
 
class wfm_admin extends wf_module {
	public function __construct($wf) {
		$this->wf = $wf;
	}
	
	public function get_name() { return("admin"); }
	public function get_description()  { return("OWF Administration module"); }
	public function get_banner()  { return("admin/1.0.1-ST"); }
	public function get_version() { return("1.0.1-ST"); }
	public function get_authors() { return(array("Olivier PASCAL", "Michael VERGOZ")); }
	public function get_depends() { return(NULL); }
	
	public function get_actions() {
		return(array(
			"/admin" => array(
				WF_ROUTE_REDIRECT,
				"/admin/system",
				"Administration",
				WF_ROUTE_SHOW
			),
			
			/* system management */
			"/admin/system" => array(
				WF_ROUTE_ACTION,
				"system/system",
				"show",
				"Système",
				WF_ROUTE_SHOW,
				array("session:admin")
			),
			"/admin/system/information" => array(
				WF_ROUTE_ACTION,
				"system/information",
				"show",
				"Informations système",
				WF_ROUTE_SHOW,
				array("session:admin")
			),
			
			/* preference edition */
			"/admin/system/preferences" => array(
				WF_ROUTE_ACTION,
				"system/preferences",
				"show_groups",
				"Préférences système",
				WF_ROUTE_SHOW,
				array("admin:system:preferences")
			),
			"/admin/system/preferences/vars/show" => array(
				WF_ROUTE_ACTION,
				"system/preferences",
				"show_vars",
				"Préférences système",
				WF_ROUTE_SHOW,
				array("admin:system:preferences")
			),
			"/admin/system/preferences/vars/edit" => array(
				WF_ROUTE_ACTION,
				"system/preferences",
				"edit_var",
				"Préférences système",
				WF_ROUTE_SHOW,
				array("admin:system:preferences")
			),
			
			/* users management */
			"/admin/system/users" => array(
				WF_ROUTE_REDIRECT,
				"/admin/system/users/list",
				"Utilisateurs",
				WF_ROUTE_SHOW,
				array("admin:system:users")
			),
			"/admin/system/users/list" => array(
				WF_ROUTE_ACTION,
				"system/users",
				"show",
				"Liste des utilisateurs",
				WF_ROUTE_HIDE,
				array("admin:system:users:list")
			),
			"/admin/system/users/list/edit" => array(
				WF_ROUTE_ACTION,
				"system/users",
				"list_edit",
				"Edition d'un utilisateur",
				WF_ROUTE_HIDE,
				array("admin:system:users:manage")
			),
			"/admin/system/users/add" => array(
				WF_ROUTE_ACTION,
				"system/users",
				"add",
				"Ajoute un utilisateur",
				WF_ROUTE_HIDE,
				array("admin:system:users:manage")
			),
			"/admin/system/users/edit" => array(
				WF_ROUTE_ACTION,
				"system/users",
				"edit",
				"Édite un utilisateur",
				WF_ROUTE_HIDE,
				array("admin:system:users:manage")
			),
			"/admin/system/users/delete" => array(
				WF_ROUTE_ACTION,
				"system/users",
				"delete",
				"Supprime un utilisateur",
				WF_ROUTE_HIDE,
				array("admin:system:users:manage")
			),
			
			/* profile */
			"/admin/myprofile" => array(
				WF_ROUTE_REDIRECT,
				"/admin/system/profiles/show",
				"Mon profil",
				WF_ROUTE_SHOW,
				array("session:simple")
			),
			"/admin/system/profiles/show" => array(
				WF_ROUTE_ACTION,
				"system/profiles",
				"show",
				"Affiche un profil utilisateur",
				WF_ROUTE_HIDE,
				array("session:simple")
			),
			"/admin/system/profiles/edit" => array(
				WF_ROUTE_ACTION,
				"system/profiles",
				"edit",
				"Édite un profil utilisateur",
				WF_ROUTE_HIDE,
				array("session:simple")
			),
		));
	}

	public function get_index() {
		$tpl = new core_tpl($this->wf);
		$tpl->set('nb_users', count($this->wf->core_session()->user_list()));
		$tpl->set('nb_pref_groups', count($this->wf->core_pref()->group_find()));
		return($tpl->fetch('admin/system/index'));
	}
}
