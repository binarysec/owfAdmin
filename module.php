<?php
 
class admin extends wf_module {
	public function __construct($wf) {
		$this->wf = $wf;
	}
	
	public function get_name() { return("admin"); }
	public function get_description()  { return("Admin"); }
	public function get_banner()  { return("Admin/1.0"); }
	public function get_version() { return("1.0"); }
	public function get_authors() { return("Olivier PASCAL, Michael VERGOZ"); }
	public function get_depends() { return(NULL); }
	
	public function get_actions() {
		return(array(
			"/admin" => array(
				WF_ROUTE_ACTION,
				"admin",
				"show",
				"Administration",
				WF_ROUTE_SHOW,
				array("session:admin")
			),
			
			/* system management */
			"/admin/system" => array(
				WF_ROUTE_REDIRECT,
				"/admin/system/users",
				"Gestion système",
				WF_ROUTE_SHOW
			),
			"/admin/system/information" => array(
				WF_ROUTE_ACTION,
				"system/information",
				"show",
				"System information",
				WF_ROUTE_SHOW,
				array("session:admin")
			),
			
			/* preference edition */
			"/admin/system/preferences" => array(
				WF_ROUTE_ACTION,
				"system/preferences",
				"show_groups",
				"Edit system preferences",
				WF_ROUTE_SHOW,
				array("system:preferences")
			),
			"/admin/system/preferences/vars/show" => array(
				WF_ROUTE_ACTION,
				"system/preferences",
				"show_vars",
				"Edit system preferences",
				WF_ROUTE_SHOW,
				array("system:preferences")
			),
			"/admin/system/preferences/vars/edit" => array(
				WF_ROUTE_ACTION,
				"system/preferences",
				"edit_var",
				"Edit system preferences",
				WF_ROUTE_SHOW,
				array("system:preferences")
			),
			
			/* users management */
			"/admin/system/users" => array(
				WF_ROUTE_REDIRECT,
				"/admin/system/users/list",
				"Gestionnaire des utilisateurs",
				WF_ROUTE_SHOW
			),
			"/admin/system/users/list" => array(
				WF_ROUTE_ACTION,
				"system/users",
				"show",
				"Liste des utilisateurs",
				WF_ROUTE_HIDE,
				array("session:admin")
			),
			"/admin/system/users/add" => array(
				WF_ROUTE_ACTION,
				"system/users",
				"add",
				"Ajoute un utilisateur",
				WF_ROUTE_HIDE,
				array("session:admin")
			),
			"/admin/system/users/edit" => array(
				WF_ROUTE_ACTION,
				"system/users",
				"edit",
				"Edite un utilisateur",
				WF_ROUTE_HIDE,
				array("session:admin")
			),
			"/admin/system/users/delete" => array(
				WF_ROUTE_ACTION,
				"system/users",
				"delete",
				"Supprime un utilisateur",
				WF_ROUTE_HIDE,
				array("session:admin")
			),
		));
	}
}
