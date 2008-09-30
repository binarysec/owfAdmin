<?php
 
class admin extends wf_module {
	public function __construct($wf) {
		$this->wf = $wf;
	}
	
	public function get_name() { return("admin"); }
	public function get_description()  { return("Admin"); }
	public function get_banner()  { return("Admin/1.0"); }
	public function get_version() { return("1.0"); }
	public function get_authors() { return("Olivier PASCAL"); }
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
				"/admin/system/informations",
				"Gestion système",
				WF_ROUTE_SHOW
			),
			"/admin/system/informations" => array(
				WF_ROUTE_ACTION,
				"sys/informations",
				"show",
				"Informations",
				WF_ROUTE_HIDE,
				array("session:admin")
			),
			
			/* users management */
			"/admin/users" => array(
				WF_ROUTE_REDIRECT,
				"/admin/users/list",
				"Gestionnaire des utilisateurs",
				WF_ROUTE_SHOW
			),
			"/admin/users/list" => array(
				WF_ROUTE_ACTION,
				"users",
				"show",
				"Liste des utilisateurs",
				WF_ROUTE_HIDE,
				array("session:admin")
			),
			"/admin/users/add" => array(
				WF_ROUTE_ACTION,
				"users",
				"add",
				"Ajoute un utilisateur",
				WF_ROUTE_HIDE,
				array("session:admin")
			),
			"/admin/users/edit" => array(
				WF_ROUTE_ACTION,
				"users",
				"edit",
				"Edite un utilisateur",
				WF_ROUTE_HIDE,
				array("session:admin")
			),
			"/admin/users/delete" => array(
				WF_ROUTE_ACTION,
				"users",
				"delete",
				"Supprime un utilisateur",
				WF_ROUTE_HIDE,
				array("session:admin")
			),
		));
	}
}
